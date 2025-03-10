<?php

namespace App\Http\Controllers;

use App\Models\SipekaRekapOvertime;
use App\Models\SipekaPlant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SipekaRekapOvertimeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua plant untuk dropdown filter
        $plants = SipekaPlant::all();

        // Query awal untuk mengambil data rekap overtime dengan relasi plant
        $rekapOvertimeQuery = SipekaRekapOvertime::with('plant');

        // Filter berdasarkan Plant
        if ($request->has('plant_id') && $request->input('plant_id') != '') {
            $plantId = $request->input('plant_id');
            $rekapOvertimeQuery->where('id_plant', $plantId);
        }

        // Filter berdasarkan Periode Bulan
        if ($request->has('periode_bulan') && $request->input('periode_bulan') != '') {
            $periodeBulan = $request->input('periode_bulan');
            $rekapOvertimeQuery->where('periode_bulan_overtime', $periodeBulan);
        }

        // Filter berdasarkan Periode Tahun
        if ($request->has('periode_tahun') && $request->input('periode_tahun') != '') {
            $periodeTahun = $request->input('periode_tahun');
            $rekapOvertimeQuery->where('periode_tahun_overtime', $periodeTahun);
        }

        // Ambil data setelah filter diterapkan
        $rekapOvertime = $rekapOvertimeQuery->get();

        return view('overtime.index-rekap-overtime', compact('rekapOvertime', 'plants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
            'periode_bulan_overtime' => 'required|string',
            'periode_tahun_overtime' => 'required|integer',
        ]);

        SipekaRekapOvertime::create([
            'id_plant' => $request->id_plant,
            'total_act_overtime' => null,  // Default null
            'total_convert_overtime' => null, // Default null
            'periode_bulan_overtime' => $request->periode_bulan_overtime,
            'periode_tahun_overtime' => $request->periode_tahun_overtime,
        ]);

        return redirect()->route('rekapOvertime.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id_rekap_overtime)
    {
        // Validasi input hanya untuk plant
        $request->validate([
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
        ]);

        // Cari data dan update hanya plant
        $rekapOvertime = SipekaRekapOvertime::findOrFail($id_rekap_overtime);
        $rekapOvertime->update([
            'id_plant' => $request->id_plant,
        ]);

        return redirect()->route('rekapOvertime.index')->with('success', 'Plant berhasil diperbarui');
    }

    public function destroy($id_rekap_overtime)
    {
        // Cari data berdasarkan ID
        $rekapOvertime = SipekaRekapOvertime::findOrFail($id_rekap_overtime);

        // Hapus data
        $rekapOvertime->delete();

        return redirect()->route('rekapOvertime.index')->with('success', 'Data berhasil dihapus');
    }

}
