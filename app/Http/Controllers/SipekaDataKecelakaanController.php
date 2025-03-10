<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SipekaDataKecelakaan;
use App\Models\SipekaRekapKecelakaan;
use App\Models\SipekaDepartemen;
use Illuminate\Support\Facades\Log;
use App\Models\SipekaPlant;

class SipekaDataKecelakaanController extends Controller
{
    public function index(Request $request, $id_rekap_kecelakaan)
    {
        // Ambil data rekap kecelakaan berdasarkan ID
        $rekapKecelakaan = SipekaRekapKecelakaan::with('dataKecelakaan')->findOrFail($id_rekap_kecelakaan);

        // Query awal untuk mengambil data kecelakaan terkait
        $dataKecelakaansQuery = SipekaDataKecelakaan::where('id_rekap_kecelakaan', $id_rekap_kecelakaan)->with('departemen');

        // Ambil daftar semua departemen untuk filter
        $departemen = SipekaDepartemen::all();

        // Filter berdasarkan Departemen (jika ada)
        if ($request->has('departemen_id') && $request->input('departemen_id') != '') {
            $departemenId = $request->input('departemen_id');
            $dataKecelakaansQuery->where('id_departemen', $departemenId);
        }

        // Ambil semua data kecelakaan setelah filter diterapkan
        $dataKecelakaans = $dataKecelakaansQuery->get();

        return view('kecelakaan.index-data-kecelakaan', compact('rekapKecelakaan', 'dataKecelakaans', 'departemen'));
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_rekap_kecelakaan' => 'required|exists:sipeka_rekap_kecelakaan,id_rekap_kecelakaan',
            'id_departemen' => 'required|exists:sipeka_departemen,id_departemen',  // Validasi departemen
            'nama_kecelakaan' => 'required|string',
            'jumlah_korban_kecelakaan' => 'nullable|integer',
            'deskripsi_kecelakaan' => 'nullable|string',
            'tanggal_kecelakaan' => 'required|date',
        ]);

        // Simpan data kecelakaan
        SipekaDataKecelakaan::create([
            'id_rekap_kecelakaan' => $request->id_rekap_kecelakaan,
            'id_departemen' => $request->id_departemen,  // Simpan id_departemen
            'nama_kecelakaan' => $request->nama_kecelakaan,
            'jumlah_korban_kecelakaan' => $request->jumlah_korban_kecelakaan ?? null,
            'deskripsi_kecelakaan' => $request->deskripsi_kecelakaan ?? null,
            'tanggal_kecelakaan' => $request->tanggal_kecelakaan,
        ]);

        return redirect()->route('dataKecelakaan.index', $request->id_rekap_kecelakaan)
            ->with('success', 'Data Kecelakaan berhasil ditambahkan');
    }

    public function update(Request $request, $id_data_kecelakaan)
    {
        // Validasi input
        $validatedData = $request->validate([
            'id_departemen' => 'required|exists:sipeka_departemen,id_departemen',  // Validasi departemen
            'nama_kecelakaan' => 'required|string',
            'jumlah_korban_kecelakaan' => 'nullable|integer',
            'deskripsi_kecelakaan' => 'nullable|string',
            'tanggal_kecelakaan' => 'required|date',
        ]);

        // Ambil data kecelakaan berdasarkan ID
        $kecelakaan = SipekaDataKecelakaan::findOrFail($id_data_kecelakaan);

        // Update data kecelakaan
        $kecelakaan->update([
            'id_departemen' => $request->id_departemen,  // Update departemen
            'nama_kecelakaan' => $request->nama_kecelakaan,
            'jumlah_korban_kecelakaan' => $request->jumlah_korban_kecelakaan,
            'deskripsi_kecelakaan' => $request->deskripsi_kecelakaan,
            'tanggal_kecelakaan' => $request->tanggal_kecelakaan,
        ]);

        // Redirect setelah update
        return redirect()->route('dataKecelakaan.index', $kecelakaan->id_rekap_kecelakaan)
            ->with('success', 'Data Kecelakaan berhasil diperbarui');
    }

    public function destroy($id_data_kecelakaan)
    {
        try {
            // Temukan data kecelakaan berdasarkan ID
            $dataKecelakaans = SipekaDataKecelakaan::findOrFail($id_data_kecelakaan);

            // Hapus data Kaizen
            $dataKecelakaans->delete();

            // Log penghapusan
            Log::info('Data Kecelakaan berhasil dihapus', ['id' => $dataKecelakaans->id_data_kecelakaan]);

            // Redirect dengan pesan sukses
            return redirect()->route('dataKecelakaan.index', ['id_rekap_kecelakaan' => $dataKecelakaans->id_rekap_kecelakaan])
                ->with('success', 'Data Kecelakaan berhasil dihapus.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error saat menghapus data Asesmen', ['error' => $e->getMessage()]);

            // Redirect dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }



}
