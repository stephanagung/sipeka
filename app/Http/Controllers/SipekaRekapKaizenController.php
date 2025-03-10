<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SipekaRekapKaizen;
use App\Models\SipekaPlant;
use App\Models\SipekaDepartemen;
use App\Models\SipekaDataKaizen;
use Illuminate\Support\Facades\Session;


class SipekaRekapKaizenController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua data rekap kaizen beserta relasi plant dan departemen
        $rekapKaizenQuery = SipekaRekapKaizen::with(['plant', 'departemen']);
        $plants = SipekaPlant::all();
        $departemen = SipekaDepartemen::all();

        // Ambil data pengguna yang login
        $user = Session::get('user');
        $userDepartemen = Session::get('user_departemen'); // Ambil ID Departemen dari sesi

        // Filter berdasarkan Plant
        if ($request->has('plant_id') && $request->input('plant_id') != '') {
            $plantId = $request->input('plant_id');
            $rekapKaizenQuery->where('id_plant', $plantId);
        }

        // Filter berdasarkan Periode Bulan
        if ($request->has('periode_bulan') && $request->input('periode_bulan') != '') {
            $periodeBulan = $request->input('periode_bulan');
            $rekapKaizenQuery->where('periode_bulan_kaizen', $periodeBulan);
        }

        // Filter berdasarkan Periode Tahun
        if ($request->has('periode_tahun') && $request->input('periode_tahun') != '') {
            $periodeTahun = $request->input('periode_tahun');
            $rekapKaizenQuery->where('periode_tahun_kaizen', $periodeTahun);
        }

        // Ambil data setelah filter diterapkan
        $rekapKaizen = $rekapKaizenQuery->get();

        // Ambil data Kaizen terkait berdasarkan ID rekap kaizen dan departemen pengguna
        $rekapKaizenPerDepartemen = [];

        foreach ($rekapKaizen as $rekap) {
            $dataKaizen = SipekaDataKaizen::where('id_rekap_kaizen', $rekap->id_rekap_kaizen)->get();

            // Hitung total Kaizen berdasarkan departemen pengguna yang login
            $totalKaizen = 0;
            foreach ($dataKaizen as $kaizen) {
                // Jika pengguna bukan Quality Management System, filter berdasarkan departemen
                if ($userDepartemen == $kaizen->pengguna->id_departemen) {
                    $totalKaizen += $kaizen->jumlah_kaizen;
                }
            }

            // Masukkan total Kaizen per departemen ke dalam array
            $rekapKaizenPerDepartemen[$rekap->id_rekap_kaizen] = $totalKaizen;
        }

        // Kirim data ke view
        return view('kaizen.index-rekap-kaizen', compact('rekapKaizen', 'plants', 'departemen', 'rekapKaizenPerDepartemen'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
            'periode_bulan_kaizen' => 'required|string',
            'periode_tahun_kaizen' => 'required|integer',
        ]);

        // Simpan data tanpa total_kaizen (akan default NULL)
        SipekaRekapKaizen::create([
            'id_plant' => $request->id_plant,
            'total_kaizen' => null, // Default NULL
            'periode_bulan_kaizen' => $request->periode_bulan_kaizen,
            'periode_tahun_kaizen' => $request->periode_tahun_kaizen,
        ]);

        return redirect()->route('rekapKaizen.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id_rekap_kaizen)
    {
        // Validasi input
        $request->validate([
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
            'periode_bulan_kaizen' => 'required|string',
            'periode_tahun_kaizen' => 'required|integer',
        ]);

        // Cari data dan update
        $rekapKaizen = SipekaRekapKaizen::findOrFail($id_rekap_kaizen);
        $rekapKaizen->update([
            'id_plant' => $request->id_plant,
            'periode_bulan_kaizen' => $request->periode_bulan_kaizen,
            'periode_tahun_kaizen' => $request->periode_tahun_kaizen,
        ]);

        return redirect()->route('rekapKaizen.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id_rekap_kaizen)
    {
        // Cari data berdasarkan ID
        $rekapKaizen = SipekaRekapKaizen::findOrFail($id_rekap_kaizen);

        // Hapus data
        $rekapKaizen->delete();

        return redirect()->route('rekapKaizen.index')->with('success', 'Data berhasil dihapus');
    }

}
