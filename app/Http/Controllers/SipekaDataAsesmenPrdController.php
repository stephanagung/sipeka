<?php

namespace App\Http\Controllers;

use App\Models\SipekaDataAsesmenPrd;
use App\Models\SipekaRekapAsesmenPrd;
use Illuminate\Support\Facades\Log;
use App\Models\SipekaPlant;
use Illuminate\Http\Request;

class SipekaDataAsesmenPrdController extends Controller
{
    public function index(Request $request, $id_rekap_asesmen_prd)
    {
        // Ambil data rekap asesmen berdasarkan ID
        $rekapAsesmen = SipekaRekapAsesmenPrd::with('dataAsesmenPrd')->findOrFail($id_rekap_asesmen_prd);

        // Query awal untuk mengambil data asesmen terkait
        $dataAsesmenQuery = SipekaDataAsesmenPrd::where('id_rekap_asesmen_prd', $id_rekap_asesmen_prd);

        // Daftar enum grup asesmen berdasarkan skema database
        $grupAsesmenEnum = [
            'Produksi Injection Grup A',
            'Produksi Injection Grup B',
            'Produksi Injection Grup C',
            'Assy'
        ];

        // Filter berdasarkan Grup Asesmen (jika ada)
        if ($request->has('grup_asesmen') && $request->input('grup_asesmen') != '') {
            $grupAsesmen = $request->input('grup_asesmen');
            $dataAsesmenQuery->where('grup_asesmen', $grupAsesmen);
        }

        // Ambil semua data asesmen setelah filter diterapkan
        $dataAsesmen = $dataAsesmenQuery->get();

        // Ambil semua daftar plant
        $plants = SipekaPlant::all();

        return view('asesmen-prd.index-data-asesmen-prd', compact('rekapAsesmen', 'dataAsesmen', 'plants', 'grupAsesmenEnum'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_rekap_asesmen_prd' => 'required|exists:sipeka_rekap_asesmen_prd,id_rekap_asesmen_prd',
            'grup_asesmen' => 'required|in:Produksi Injection Grup A,Produksi Injection Grup B,Produksi Injection Grup C,Assy',
            'jumlah_plan_asesmen' => 'nullable|integer',
            'jumlah_act_asesmen' => 'nullable|integer',
        ]);

        // Cek apakah grup asesmen sudah ada dalam database untuk rekap asesmen ini
        $exists = SipekaDataAsesmenPrd::where('id_rekap_asesmen_prd', $request->id_rekap_asesmen_prd)
            ->where('grup_asesmen', $request->grup_asesmen)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Grup Asesmen ini sudah ditambahkan.');
        }

        // Simpan data baru
        SipekaDataAsesmenPrd::create([
            'id_rekap_asesmen_prd' => $request->id_rekap_asesmen_prd,
            'grup_asesmen' => $request->grup_asesmen,
            'jumlah_plan_asesmen' => $request->jumlah_plan_asesmen ?? null,
            'jumlah_act_asesmen' => $request->jumlah_act_asesmen ?? null,
        ]);

        return redirect()->route('dataAsesmenPrd.index', $request->id_rekap_asesmen_prd)
            ->with('success', 'Data Asesmen berhasil ditambahkan.');
    }

    public function update(Request $request, $id_data_asesmen_prd)
    {
        // Validasi input
        $request->validate([
            'grup_asesmen' => 'required|in:Produksi Injection Grup A,Produksi Injection Grup B,Produksi Injection Grup C,Assy',
            'jumlah_plan_asesmen' => 'nullable|integer',
            'jumlah_act_asesmen' => 'nullable|integer',
        ]);

        // Cari data yang akan diupdate
        $dataAsesmen = SipekaDataAsesmenPrd::findOrFail($id_data_asesmen_prd);

        // Cek apakah grup asesmen sudah ada untuk rekap asesmen ini, kecuali yang sedang diedit
        $exists = SipekaDataAsesmenPrd::where('id_rekap_asesmen_prd', $dataAsesmen->id_rekap_asesmen_prd)
            ->where('grup_asesmen', $request->grup_asesmen)
            ->where('id_data_asesmen_prd', '!=', $id_data_asesmen_prd)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Grup Asesmen ini sudah ada.');
        }

        // Update data
        $dataAsesmen->update([
            'grup_asesmen' => $request->grup_asesmen,
            'jumlah_plan_asesmen' => $request->jumlah_plan_asesmen ?? null,
            'jumlah_act_asesmen' => $request->jumlah_act_asesmen ?? null,
        ]);

        return redirect()->route('dataAsesmenPrd.index', $dataAsesmen->id_rekap_asesmen_prd)
            ->with('success', 'Data Asesmen berhasil diperbarui.');
    }


    public function destroy($id_data_asesmen_prd)
    {
        try {
            // Temukan data Kaizen berdasarkan ID
            $dataAsesmenPrd = SipekaDataAsesmenPrd::findOrFail($id_data_asesmen_prd);

            // Hapus data Kaizen
            $dataAsesmenPrd->delete();

            // Log penghapusan
            Log::info('Data Asesmen berhasil dihapus', ['id' => $dataAsesmenPrd->id_data_asesmen_prd]);

            // Redirect dengan pesan sukses
            return redirect()->route('dataAsesmenPrd.index', ['id_rekap_asesmen_prd' => $dataAsesmenPrd->id_rekap_asesmen_prd])
                ->with('success', 'Data Asesmen berhasil dihapus.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error saat menghapus data Asesmen', ['error' => $e->getMessage()]);

            // Redirect dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }


}
