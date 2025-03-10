<?php

namespace App\Http\Controllers;

use App\Models\SipekaRekapAsesmenPrd;
use App\Models\SipekaPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SipekaRekapAsesmenPrdController extends Controller
{
    // Menampilkan data Rekap Asesmen
    public function index(Request $request)
    {
        // Ambil semua plant untuk dropdown filter
        $plants = SipekaPlant::all();

        // Query awal untuk mengambil data rekap asesmen dengan relasi plant
        $rekapAsesmenPrdQuery = SipekaRekapAsesmenPrd::with('plant');

        // Filter berdasarkan Plant
        if ($request->has('plant_id') && $request->input('plant_id') != '') {
            $plantId = $request->input('plant_id');
            $rekapAsesmenPrdQuery->where('id_plant', $plantId);
        }

        // Filter berdasarkan Periode Bulan
        if ($request->has('periode_bulan') && $request->input('periode_bulan') != '') {
            $periodeBulan = $request->input('periode_bulan');
            $rekapAsesmenPrdQuery->where('periode_bulan_asesmen_prd', $periodeBulan);
        }

        // Filter berdasarkan Periode Tahun
        if ($request->has('periode_tahun') && $request->input('periode_tahun') != '') {
            $periodeTahun = $request->input('periode_tahun');
            $rekapAsesmenPrdQuery->where('periode_tahun_asesmen_prd', $periodeTahun);
        }

        // Ambil data setelah filter diterapkan
        $rekapAsesmenPrd = $rekapAsesmenPrdQuery->get();

        return view('asesmen-prd.index-rekap-asesmen-prd', compact('rekapAsesmenPrd', 'plants'));
    }

    // Menyimpan data Rekap Asesmen
    public function store(Request $request)
    {
        $request->validate([
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
            'total_plan_asesmen_prd' => 'nullable|integer',
            'total_actual_asesmen_prd' => 'nullable|integer',
            'periode_bulan_asesmen_prd' => 'required|string',
            'periode_tahun_asesmen_prd' => 'required|integer',
        ]);

        SipekaRekapAsesmenPrd::create($request->all());
        return redirect()->route('rekapAsesmenPrd.index')->with('success', 'Data berhasil ditambahkan');
    }

    // Mengupdate data berdasarkan ID
    public function update(Request $request, $id_rekap_asesmen_prd)
    {
        // Validasi input
        $request->validate([
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
            'periode_bulan_asesmen_prd' => 'required|string',
            'periode_tahun_asesmen_prd' => 'required|integer',
            'total_plan_asesmen_prd' => 'required|integer',
        ]);

        // Cari data dan update
        $rekapAsesmenPrd = SipekaRekapAsesmenPrd::findOrFail($id_rekap_asesmen_prd);
        $rekapAsesmenPrd->update([
            'id_plant' => $request->id_plant,
            'periode_bulan_asesmen_prd' => $request->periode_bulan_asesmen_prd,
            'periode_tahun_asesmen_prd' => $request->periode_tahun_asesmen_prd,
            'total_plan_asesmen_prd' => $request->total_plan_asesmen_prd,
        ]);

        return redirect()->route('rekapAsesmenPrd.index')->with('success', 'Data berhasil diperbarui');
    }

    // Menghapus data Rekap Asesmen
    public function destroy($id_rekap_asesmen_prd)
    {
        // Cari data berdasarkan ID
        $rekapAsesmenPrd = SipekaRekapAsesmenPrd::findOrFail($id_rekap_asesmen_prd);

        // Hapus data
        $rekapAsesmenPrd->delete();

        return redirect()->route('rekapAsesmenPrd.index')->with('success', 'Data berhasil dihapus');
    }
}
