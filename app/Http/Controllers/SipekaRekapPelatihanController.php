<?php

namespace App\Http\Controllers;

use App\Models\SipekaRekapPelatihan;
use App\Models\SipekaPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SipekaRekapPelatihanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua plant untuk dropdown filter
        $plants = SipekaPlant::all();

        // Query awal untuk mengambil data rekap pelatihan dengan relasi plant
        $rekapPelatihanQuery = SipekaRekapPelatihan::with('plant');

        // Filter berdasarkan Plant
        if ($request->has('plant_id') && $request->input('plant_id') != '') {
            $plantId = $request->input('plant_id');
            $rekapPelatihanQuery->where('id_plant', $plantId);
        }

        // Filter berdasarkan Periode Bulan
        if ($request->has('periode_bulan') && $request->input('periode_bulan') != '') {
            $periodeBulan = $request->input('periode_bulan');
            $rekapPelatihanQuery->where('periode_bulan_pelatihan', $periodeBulan);
        }

        // Filter berdasarkan Periode Tahun
        if ($request->has('periode_tahun') && $request->input('periode_tahun') != '') {
            $periodeTahun = $request->input('periode_tahun');
            $rekapPelatihanQuery->where('periode_tahun_pelatihan', $periodeTahun);
        }

        // Ambil data setelah filter diterapkan
        $rekapPelatihan = $rekapPelatihanQuery->get();

        return view('pelatihan.index-rekap-pelatihan', compact('rekapPelatihan', 'plants'));
    }
    // Menyimpan data Rekap Pelatihan
    public function store(Request $request)
    {
        $request->validate([
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
            'total_plan_pelatihan' => 'nullable|integer',
            'total_act_pelatihan' => 'nullable|integer',
            'total_plan_partisipan' => 'nullable|integer',
            'total_act_partisipan' => 'nullable|integer',
            'periode_bulan_pelatihan' => 'required|string',
            'periode_tahun_pelatihan' => 'required|integer',
        ]);

        SipekaRekapPelatihan::create([
            'id_plant' => $request->id_plant,
            'total_plan_pelatihan' => $request->total_plan_pelatihan,
            'total_act_pelatihan' => $request->total_act_pelatihan ?? null,
            'total_plan_partisipan' => null,
            'total_act_partisipan' => $request->total_act_partisipan ?? null,
            'periode_bulan_pelatihan' => $request->periode_bulan_pelatihan,
            'periode_tahun_pelatihan' => $request->periode_tahun_pelatihan,
        ]);

        return redirect()->route('rekapPelatihan.index')->with('success', 'Data berhasil ditambahkan');
    }

    // Mengupdate Total Plan Pelatihan & Total Plan Partisipan berdasarkan ID
    public function update(Request $request, $id_rekap_pelatihan)
    {
        // Validasi input hanya untuk field yang diperbolehkan diubah
        $request->validate([
            'total_plan_pelatihan' => 'required|integer',
        ]);

        // Cari data dan update hanya field yang diperlukan
        $rekapPelatihan = SipekaRekapPelatihan::findOrFail($id_rekap_pelatihan);
        $rekapPelatihan->update([
            'total_plan_pelatihan' => $request->total_plan_pelatihan,
        ]);

        return redirect()->route('rekapPelatihan.index')->with('success', 'Data berhasil diperbarui');
    }

    // Menghapus data Rekap Pelatihan
    public function destroy($id_rekap_pelatihan)
    {
        // Cari data berdasarkan ID
        $rekapPelatihan = SipekaRekapPelatihan::findOrFail($id_rekap_pelatihan);

        // Hapus data
        $rekapPelatihan->delete();

        return redirect()->route('rekapPelatihan.index')->with('success', 'Data berhasil dihapus');
    }
}
