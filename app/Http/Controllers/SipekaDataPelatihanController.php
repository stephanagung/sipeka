<?php

namespace App\Http\Controllers;

use App\Models\SipekaDataPelatihan;
use App\Models\SipekaRekapPelatihan;
use Illuminate\Support\Facades\Log;
use App\Models\SipekaPlant;
use App\Models\SipekaDepartemen;
use Illuminate\Http\Request;

class SipekaDataPelatihanController extends Controller
{
    public function index(Request $request, $id_rekap_pelatihan)
    {
        // Ambil data rekap pelatihan berdasarkan ID
        $rekapPelatihan = SipekaRekapPelatihan::with('dataPelatihan')->findOrFail($id_rekap_pelatihan);

        // Query awal untuk mengambil data pelatihan terkait
        $dataPelatihansQuery = SipekaDataPelatihan::where('id_rekap_pelatihan', $id_rekap_pelatihan)->with('departemen');

        // Ambil daftar semua departemen untuk filter
        $departemens = SipekaDepartemen::all();

        // Filter berdasarkan Departemen (jika ada)
        if ($request->has('departemen_id') && $request->input('departemen_id') != '') {
            $departemenId = $request->input('departemen_id');
            $dataPelatihansQuery->where('id_departemen', $departemenId);
        }

        // Ambil semua data pelatihan setelah filter diterapkan
        $dataPelatihans = $dataPelatihansQuery->get();

        return view('pelatihan.index-data-pelatihan', compact('rekapPelatihan', 'dataPelatihans', 'departemens'));
    }


    public function store(Request $request)
    {
        // Validasi input 
        $request->validate([
            'id_rekap_pelatihan' => 'required|exists:sipeka_rekap_pelatihan,id_rekap_pelatihan',
            'id_departemen' => 'required|exists:sipeka_departemen,id_departemen',
            'nama_pelatihan' => 'required|string',
            'jumlah_plan_partisipan' => 'required|integer',
            'tanggal_pelatihan' => 'required|date',
        ]);

        // Simpan data baru
        SipekaDataPelatihan::create([
            'id_rekap_pelatihan' => $request->id_rekap_pelatihan,
            'id_departemen' => $request->id_departemen,
            'nama_pelatihan' => $request->nama_pelatihan,
            'jumlah_plan_partisipan' => $request->jumlah_plan_partisipan,
            'jumlah_act_partisipan' => null,
            'tanggal_pelatihan' => $request->tanggal_pelatihan,
        ]);

        return redirect()->route('dataPelatihan.index', $request->id_rekap_pelatihan)
            ->with('success', 'Data pelatihan berhasil ditambahkan');
    }

    public function update(Request $request, $id_data_pelatihan)
    {
        // Validasi input
        $request->validate([
            'id_departemen' => 'required|exists:sipeka_departemen,id_departemen',
            'nama_pelatihan' => 'required|string',
            'jumlah_plan_partisipan' => 'nullable|integer',
            'jumlah_act_partisipan' => 'nullable|integer',
            'tanggal_pelatihan' => 'required|date',
        ]);

        // Cari data yang akan diupdate
        $dataPelatihan = SipekaDataPelatihan::findOrFail($id_data_pelatihan);

        // Update data
        $dataPelatihan->update([
            'id_departemen' => $request->id_departemen,
            'nama_pelatihan' => $request->nama_pelatihan,
            'jumlah_plan_partisipan' => $request->jumlah_plan_partisipan,
            'jumlah_act_partisipan' => $request->jumlah_act_partisipan ?? null,
            'tanggal_pelatihan' => $request->tanggal_pelatihan,
        ]);

        return redirect()->route('dataPelatihan.index', $dataPelatihan->id_rekap_pelatihan)
            ->with('success', 'Data pelatihan berhasil diperbarui');
    }

    public function destroy($id_data_pelatihan)
    {
        try {
            // Temukan data pelatihan berdasarkan ID
            $dataPelatihan = SipekaDataPelatihan::findOrFail($id_data_pelatihan);

            // Hapus data pelatihan
            $dataPelatihan->delete();

            // Log penghapusan
            Log::info('Data pelatihan berhasil dihapus', ['id' => $dataPelatihan->id_data_pelatihan]);

            // Redirect dengan pesan sukses
            return redirect()->route('dataPelatihan.index', ['id_rekap_pelatihan' => $dataPelatihan->id_rekap_pelatihan])
                ->with('success', 'Data pelatihan berhasil dihapus.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error saat menghapus data pelatihan', ['error' => $e->getMessage()]);

            // Redirect dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
