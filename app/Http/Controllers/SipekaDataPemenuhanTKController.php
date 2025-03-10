<?php

namespace App\Http\Controllers;

use App\Models\SipekaDataPemenuhanTK;
use App\Models\SipekaRekapPemenuhanTK;
use Illuminate\Support\Facades\Log;
use App\Models\SipekaPlant;
use App\Models\SipekaDepartemen;
use Illuminate\Http\Request;

class SipekaDataPemenuhanTKController extends Controller
{
    public function index(Request $request, $id_rekap_pemenuhan_tk)
    {
        // Ambil data rekap pemenuhan TK berdasarkan ID
        $rekapPemenuhanTK = SipekaRekapPemenuhanTK::with('dataPemenuhanTK')->findOrFail($id_rekap_pemenuhan_tk);

        // Query awal untuk mengambil data pemenuhan TK terkait
        $dataPemenuhansQuery = SipekaDataPemenuhanTK::where('id_rekap_pemenuhan_tk', $id_rekap_pemenuhan_tk);

        // Ambil daftar semua departemen untuk filter
        $departemens = SipekaDepartemen::all();

        // Filter berdasarkan Departemen (jika ada)
        if ($request->has('departemen_id') && $request->input('departemen_id') != '') {
            $departemenId = $request->input('departemen_id');
            $dataPemenuhansQuery->where('id_departemen', $departemenId);
        }

        // Ambil daftar semua plants
        $plants = SipekaPlant::all();

        // Ambil semua data pemenuhan TK setelah filter diterapkan
        $dataPemenuhans = $dataPemenuhansQuery->get();

        return view('pemenuhan-tk.index-data-pemenuhan-tk', compact('rekapPemenuhanTK', 'dataPemenuhans', 'departemens', 'plants'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_rekap_pemenuhan_tk' => 'required|exists:sipeka_rekap_pemenuhan_tk,id_rekap_pemenuhan_tk',
            'id_departemen' => 'required|exists:sipeka_departemen,id_departemen',
            'posisi_tk' => 'required|string',
            'jumlah_plan_pemenuhan_tk' => 'required|integer',
            'jumlah_act_pemenuhan_tk' => 'nullable|integer',
            'tanggal_pemenuhan_tk' => 'required|date',
        ]);

        // Simpan data baru
        SipekaDataPemenuhanTK::create([
            'id_rekap_pemenuhan_tk' => $request->id_rekap_pemenuhan_tk,
            'id_departemen' => $request->id_departemen,
            'posisi_tk' => $request->posisi_tk,
            'jumlah_plan_pemenuhan_tk' => $request->jumlah_plan_pemenuhan_tk,
            'jumlah_act_pemenuhan_tk' => $request->jumlah_act_pemenuhan_tk ?? null,
            'tanggal_pemenuhan_tk' => $request->tanggal_pemenuhan_tk,
        ]);

        return redirect()->route('dataPemenuhanTK.index', $request->id_rekap_pemenuhan_tk)
            ->with('success', 'Data pemenuhan tenaga kerja berhasil ditambahkan');
    }

    public function update(Request $request, $id_data_pemenuhan_tk)
    {
        // Validasi input
        $request->validate([
            'id_departemen' => 'required|exists:sipeka_departemen,id_departemen',
            'posisi_tk' => 'required|string',
            'jumlah_plan_pemenuhan_tk' => 'nullable|integer',
            'jumlah_act_pemenuhan_tk' => 'nullable|integer',
            'tanggal_pemenuhan_tk' => 'required|date',
        ]);

        // Cari data yang akan diupdate
        $dataPemenuhan = SipekaDataPemenuhanTK::findOrFail($id_data_pemenuhan_tk);

        // Update data
        $dataPemenuhan->update([
            'id_departemen' => $request->id_departemen,
            'posisi_tk' => $request->posisi_tk,
            'jumlah_plan_pemenuhan_tk' => $request->jumlah_plan_pemenuhan_tk,
            'jumlah_act_pemenuhan_tk' => $request->jumlah_act_pemenuhan_tk ?? null,
            'tanggal_pemenuhan_tk' => $request->tanggal_pemenuhan_tk,
        ]);

        return redirect()->route('dataPemenuhanTK.index', $dataPemenuhan->id_rekap_pemenuhan_tk)
            ->with('success', 'Data pemenuhan tenaga kerja berhasil diperbarui');
    }

    public function destroy($id_data_pemenuhan_tk)
    {
        try {
            // Temukan data pemenuhan tk berdasarkan ID
            $dataPemenuhanTK = SipekaDataPemenuhanTK::findOrFail($id_data_pemenuhan_tk);

            // Hapus data pemenuhan tk
            $dataPemenuhanTK->delete();

            // Log penghapusan
            Log::info('Data pemenuhan tk berhasil dihapus', ['id' => $dataPemenuhanTK->id_data_pemenuhan_tk]);

            // Redirect dengan pesan sukses
            return redirect()->route('dataPemenuhanTK.index', ['id_rekap_pemenuhan_tk' => $dataPemenuhanTK->id_rekap_pemenuhan_tk])
                ->with('success', 'Data pemenuhan tk berhasil dihapus.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error saat menghapus data pemenuhan tk', ['error' => $e->getMessage()]);

            // Redirect dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

}
