<?php

namespace App\Http\Controllers;

use App\Models\SipekaRekapPemenuhanTK;
use App\Models\SipekaPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SipekaRekapPemenuhanTKController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua plant untuk dropdown filter
        $plants = SipekaPlant::all();

        // Query awal untuk mengambil data rekap pemenuhan TK dengan relasi plant
        $rekapPemenuhanTKQuery = SipekaRekapPemenuhanTK::with('plant');

        // Filter berdasarkan Plant
        if ($request->has('plant_id') && $request->input('plant_id') != '') {
            $plantId = $request->input('plant_id');
            $rekapPemenuhanTKQuery->where('id_plant', $plantId);
        }

        // Filter berdasarkan Periode Bulan
        if ($request->has('periode_bulan') && $request->input('periode_bulan') != '') {
            $periodeBulan = $request->input('periode_bulan');
            $rekapPemenuhanTKQuery->where('periode_bulan_pemenuhan_tk', $periodeBulan);
        }

        // Filter berdasarkan Periode Tahun
        if ($request->has('periode_tahun') && $request->input('periode_tahun') != '') {
            $periodeTahun = $request->input('periode_tahun');
            $rekapPemenuhanTKQuery->where('periode_tahun_pemenuhan_tk', $periodeTahun);
        }

        // Ambil data setelah filter diterapkan
        $rekapPemenuhanTK = $rekapPemenuhanTKQuery->get();

        return view('pemenuhan-tk.index-rekap-pemenuhan-tk', compact('rekapPemenuhanTK', 'plants'));
    }

    // Menyimpan data Rekap Pemenuhan TK
    public function store(Request $request)
    {
        $request->validate([
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
            'periode_bulan_pemenuhan_tk' => 'required|string',
            'periode_tahun_pemenuhan_tk' => 'required|integer',
        ]);

        SipekaRekapPemenuhanTK::create([
            'id_plant' => $request->id_plant,
            'total_plan_pemenuhan_tk' => $request->total_plan_pemenuhan_tk ?? null,
            'total_act_pemenuhan_tk' => $request->total_act_pemenuhan_tk ?? null,
            'periode_bulan_pemenuhan_tk' => $request->periode_bulan_pemenuhan_tk,
            'periode_tahun_pemenuhan_tk' => $request->periode_tahun_pemenuhan_tk,
        ]);

        return redirect()->route('rekapPemenuhanTK.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id_rekap_pemenuhan_tk)
    {
        // Validasi input hanya untuk plant
        $request->validate([
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
        ]);

        // Cari data dan update hanya plant
        $rekapPemenuhanTK = SipekaRekapPemenuhanTK::findOrFail($id_rekap_pemenuhan_tk);
        $rekapPemenuhanTK->update([
            'id_plant' => $request->id_plant,
        ]);

        return redirect()->route('rekapPemenuhanTK.index')->with('success', 'Plant berhasil diperbarui');
    }

    // Menghapus data Rekap Pemenuhan TK
    public function destroy($id_rekap_pemenuhan_tk)
    {
        // Cari data berdasarkan ID
        $rekapPemenuhanTK = SipekaRekapPemenuhanTK::findOrFail($id_rekap_pemenuhan_tk);

        // Hapus data
        $rekapPemenuhanTK->delete();

        return redirect()->route('rekapPemenuhanTK.index')->with('success', 'Data berhasil dihapus');
    }
}
