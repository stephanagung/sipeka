<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SipekaDepartemen;
use App\Models\SipekaPlant;
use App\Models\SipekaJatahAbsensi;
use App\Models\SipekaAbsensi;

class SipekaJatahAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $departemen = SipekaDepartemen::all(); // Ambil semua departemen
        $plants = SipekaPlant::all(); // Ambil semua plant

        // Query awal
        $jatahAbsensiQuery = SipekaJatahAbsensi::with('pengguna.departemen', 'pengguna.plant');

        // Filter berdasarkan Departemen
        if ($request->has('departemen_id') && $request->input('departemen_id') != '') {
            $departemenId = $request->input('departemen_id');
            $jatahAbsensiQuery->whereHas('pengguna', function ($query) use ($departemenId) {
                $query->where('id_departemen', $departemenId);
            });
        }

        // Filter berdasarkan Plant
        if ($request->has('plant_id') && $request->input('plant_id') != '') {
            $plantId = $request->input('plant_id');
            $jatahAbsensiQuery->whereHas('pengguna', function ($query) use ($plantId) {
                $query->where('id_plant', $plantId);
            });
        }

        // Eksekusi query setelah semua filter diterapkan
        $jatahAbsensi = $jatahAbsensiQuery->get();

        return view('jatah.index-jatah-absensi', compact('jatahAbsensi', 'departemen', 'plants'));
    }

    public function showDetail($id_jatah_absensi)
    {
        // Ambil data absensi yang terkait dengan id_jatah_absensi
        $absensi = SipekaAbsensi::where('id_jatah_absensi', $id_jatah_absensi)->get();

        // Ambil data jatah absensi beserta data pengguna yang terkait
        $jatahAbsensi = SipekaJatahAbsensi::with('pengguna')->find($id_jatah_absensi);

        // Pastikan data ditemukan
        if (!$jatahAbsensi) {
            return redirect()->back()->with('error', 'Jatah absensi tidak ditemukan.');
        }

        // Ambil data pengguna terkait
        $pengguna = $jatahAbsensi->pengguna;

        // Gabungkan data absensi dan pengguna untuk ditampilkan di view
        return view('jatah.index-list-absensi', compact('absensi', 'pengguna', 'jatahAbsensi'));
    }

    public function update(Request $request, $id_jatah_absensi)
    {
        // Validasi input
        $request->validate([
            'total_jatah_absensi' => 'required|numeric|min:0',
        ]);

        // Cari data berdasarkan ID jatah absensi
        $jatahAbsensi = SipekaJatahAbsensi::find($id_jatah_absensi);

        // Jika data tidak ditemukan
        if (!$jatahAbsensi) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Update kolom total_jatah_absensi
        $jatahAbsensi->total_jatah_absensi = $request->total_jatah_absensi;
        $jatahAbsensi->save();

        // Redirect kembali ke halaman yang sama (halaman detail) dengan pesan sukses
        return back()->with('success', 'Kuota cuti berhasil diperbarui.');
    }

}
