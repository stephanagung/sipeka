<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\SipekaDataKaizen;
use App\Models\SipekaPengguna;
use App\Models\SipekaRekapKaizen;
use App\Models\SipekaPlant;
use App\Models\SipekaDepartemen;

class SipekaDataKaizenController extends Controller
{

    public function index(Request $request, $id_rekap_kaizen)
    {
        // Ambil data rekap kaizen berdasarkan ID
        $rekapKaizen = SipekaRekapKaizen::with('plant')->where('id_rekap_kaizen', $id_rekap_kaizen)->first();

        // Jika data tidak ditemukan, redirect ke halaman utama
        if (!$rekapKaizen) {
            return redirect()->route('rekapKaizen.index')->with('error', 'Data rekap kaizen tidak ditemukan.');
        }

        // Ambil periode bulan dan tahun dari rekap kaizen
        $periode_bulan = $rekapKaizen->periode_bulan_kaizen;
        $periode_tahun = $rekapKaizen->periode_tahun_kaizen;

        // Ambil id_plant dari rekap kaizen
        $id_plant = $rekapKaizen->id_plant;

        // Ambil daftar pengguna berdasarkan id_plant
        $pengguna = SipekaPengguna::where('id_plant', $id_plant)->get();

        // Ambil daftar departemen
        $departemens = SipekaDepartemen::all();

        // Ambil data kaizen berdasarkan id_rekap_kaizen
        $dataKaizenQuery = SipekaDataKaizen::where('id_rekap_kaizen', $id_rekap_kaizen)
            ->with('pengguna');

        // Filter berdasarkan Departemen
        if ($request->has('departemen_id') && $request->input('departemen_id') != '') {
            $departemenId = $request->input('departemen_id');
            $dataKaizenQuery->whereHas('pengguna', function ($query) use ($departemenId) {
                $query->where('id_departemen', $departemenId);
            });
        }

        $dataKaizen = $dataKaizenQuery->get();

        // Ambil data pengguna yang login
        $userDepartemenId = Session::get('user_departemen'); // ID Departemen dari sesi

        // Hitung total Kaizen berdasarkan departemen pengguna
        $totalKaizenByDept = $dataKaizen->sum('jumlah_kaizen');

        // Kirim data ke view
        return view('kaizen.index-data-kaizen', compact('dataKaizen', 'id_rekap_kaizen', 'rekapKaizen', 'pengguna', 'departemens', 'periode_bulan', 'periode_tahun', 'totalKaizenByDept'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_rekap_kaizen' => 'required|exists:sipeka_rekap_kaizen,id_rekap_kaizen',
            'id_pengguna' => 'required|exists:sipeka_pengguna,id_pengguna',
            'nama_kaizen' => 'required|string|max:255',
            'jumlah_kaizen' => 'nullable|integer',
            'tanggal_penerbitan_kaizen' => 'required|date',
        ]);

        // Simpan data
        SipekaDataKaizen::create([
            'id_rekap_kaizen' => $request->id_rekap_kaizen,
            'id_pengguna' => $request->id_pengguna,
            'nama_kaizen' => $request->nama_kaizen,
            'jumlah_kaizen' => $request->jumlah_kaizen,
            'tanggal_penerbitan_kaizen' => $request->tanggal_penerbitan_kaizen,
        ]);

        return redirect()->route('dataKaizen.index', ['id_rekap_kaizen' => $request->id_rekap_kaizen])
            ->with('success', 'Data Kaizen berhasil ditambahkan.');
    }

    public function update(Request $request, $id_data_kaizen)
    {
        try {
            $dataKaizen = SipekaDataKaizen::findOrFail($id_data_kaizen);
            $rekapKaizen = SipekaRekapKaizen::where('id_rekap_kaizen', $dataKaizen->id_rekap_kaizen)->firstOrFail();

            $request->validate([
                'nama_kaizen' => 'required|string|max:255',
                'jumlah_kaizen' => 'nullable|integer',
                'tanggal_penerbitan_kaizen' => 'required|date',
            ]);

            $bulanInput = \Carbon\Carbon::parse($request->tanggal_penerbitan_kaizen)->translatedFormat('F');
            $tahunInput = \Carbon\Carbon::parse($request->tanggal_penerbitan_kaizen)->format('Y');

            if (strtolower($bulanInput) !== strtolower($rekapKaizen->periode_bulan_kaizen) || $tahunInput !== (string) $rekapKaizen->periode_tahun_kaizen) {
                Log::warning('Tanggal penerbitan tidak sesuai dengan periode', [
                    'input_bulan' => $bulanInput,
                    'input_tahun' => $tahunInput,
                    'rekap_bulan' => $rekapKaizen->periode_bulan_kaizen,
                    'rekap_tahun' => $rekapKaizen->periode_tahun_kaizen,
                ]);

                return redirect()->back()->withErrors([
                    'tanggal_penerbitan_kaizen' => 'Tanggal penerbitan harus sesuai dengan periode bulan dan tahun.'
                ]);
            }

            $dataKaizen->update([
                'nama_kaizen' => $request->nama_kaizen,
                'jumlah_kaizen' => $request->jumlah_kaizen,
                'tanggal_penerbitan_kaizen' => $request->tanggal_penerbitan_kaizen,
            ]);

            Log::info('Data Kaizen berhasil diperbarui', ['id' => $dataKaizen->id_data_kaizen, 'data' => $request->all()]);

            return redirect()->route('dataKaizen.index', ['id_rekap_kaizen' => $dataKaizen->id_rekap_kaizen])
                ->with('success', 'Data Kaizen berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error saat memperbarui data Kaizen', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id_data_kaizen)
    {
        try {
            // Temukan data Kaizen berdasarkan ID
            $dataKaizen = SipekaDataKaizen::findOrFail($id_data_kaizen);

            // Hapus data Kaizen
            $dataKaizen->delete();

            // Log penghapusan
            Log::info('Data Kaizen berhasil dihapus', ['id' => $dataKaizen->id_data_kaizen]);

            // Redirect dengan pesan sukses
            return redirect()->route('dataKaizen.index', ['id_rekap_kaizen' => $dataKaizen->id_rekap_kaizen])
                ->with('success', 'Data Kaizen berhasil dihapus.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error saat menghapus data Kaizen', ['error' => $e->getMessage()]);

            // Redirect dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }


}
