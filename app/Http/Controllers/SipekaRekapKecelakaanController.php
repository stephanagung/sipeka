<?php

namespace App\Http\Controllers;

use App\Models\SipekaRekapKecelakaan;
use App\Models\SipekaPlant;
use Illuminate\Http\Request;

class SipekaRekapKecelakaanController extends Controller
{
    // Menampilkan data Rekap Kecelakaan
    public function index(Request $request)
    {
        // Ambil semua plant untuk dropdown filter
        $plants = SipekaPlant::all();

        // Query awal untuk mengambil data rekap kecelakaan dengan relasi plant
        $rekapKecelakaanQuery = SipekaRekapKecelakaan::with('plant');

        // Filter berdasarkan Plant
        if ($request->has('plant_id') && $request->input('plant_id') != '') {
            $plantId = $request->input('plant_id');
            $rekapKecelakaanQuery->where('id_plant', $plantId);
        }

        // Filter berdasarkan Periode Bulan
        if ($request->has('periode_bulan') && $request->input('periode_bulan') != '') {
            $periodeBulan = $request->input('periode_bulan');
            $rekapKecelakaanQuery->where('periode_bulan_kecelakaan', $periodeBulan);
        }

        // Filter berdasarkan Periode Tahun
        if ($request->has('periode_tahun') && $request->input('periode_tahun') != '') {
            $periodeTahun = $request->input('periode_tahun');
            $rekapKecelakaanQuery->where('periode_tahun_kecelakaan', $periodeTahun);
        }

        // Ambil data setelah filter diterapkan
        $rekapKecelakaan = $rekapKecelakaanQuery->get();

        return view('kecelakaan.index-rekap-kecelakaan', compact('rekapKecelakaan', 'plants'));
    }

    // Menyimpan data Rekap Kecelakaan
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
            'total_kecelakaan' => 'nullable|integer',
            'total_korban_kecelakaan' => 'nullable|integer',
            'periode_bulan_kecelakaan' => 'required|string',
            'periode_tahun_kecelakaan' => 'required|integer',
        ]);

        // Simpan data ke tabel 'sipeka_rekap_kecelakaan'
        SipekaRekapKecelakaan::create($request->all());

        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->route('rekapKecelakaan.index')->with('success', 'Data Rekap Kecelakaan berhasil ditambahkan');
    }

    // Menghapus data Rekap Kecelakaan
    public function destroy($id_rekap_kecelakaan)
    {
        // Cari data berdasarkan ID
        $rekapKecelakaan = SipekaRekapKecelakaan::findOrFail($id_rekap_kecelakaan);

        // Hapus data
        $rekapKecelakaan->delete();

        return redirect()->route('rekapKecelakaan.index')->with('success', 'Data berhasil dihapus');
    }
}
