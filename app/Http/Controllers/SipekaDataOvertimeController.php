<?php

namespace App\Http\Controllers;

use App\Models\SipekaDataOvertime;
use App\Models\SipekaRekapOvertime;
use Illuminate\Support\Facades\Log;
use App\Models\SipekaPlant;
use App\Models\SipekaDepartemen;
use Illuminate\Http\Request;

class SipekaDataOvertimeController extends Controller
{
    public function index($id_rekap_overtime)
    {
        // Ambil data rekap overtime berdasarkan ID
        $rekapOvertime = SipekaRekapOvertime::with('dataOvertime')->findOrFail($id_rekap_overtime);

        // Ambil semua data overtime terkait dengan rekap overtime
        $dataOvertimes = $rekapOvertime->dataOvertime;

        // Ambil daftar semua plants
        $plants = SipekaPlant::all();

        // Ambil daftar departemen
        $departemens = SipekaDepartemen::all();

        return view('overtime.index-data-overtime', compact('rekapOvertime', 'dataOvertimes', 'departemens', 'plants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rekap_overtime' => 'required|exists:sipeka_rekap_overtime,id_rekap_overtime',
            'jumlah_act_overtime_minggu_1' => 'nullable|numeric',
            'jumlah_convert_overtime_minggu_1' => 'nullable|numeric',
            'jumlah_act_overtime_minggu_2' => 'nullable|numeric',
            'jumlah_convert_overtime_minggu_2' => 'nullable|numeric',
            'jumlah_act_overtime_minggu_3' => 'nullable|numeric',
            'jumlah_convert_overtime_minggu_3' => 'nullable|numeric',
            'jumlah_act_overtime_minggu_4' => 'nullable|numeric',
            'jumlah_convert_overtime_minggu_4' => 'nullable|numeric',
            'jumlah_act_overtime_minggu_5' => 'nullable|numeric',
            'jumlah_convert_overtime_minggu_5' => 'nullable|numeric',
        ]);

        SipekaDataOvertime::create([
            'id_rekap_overtime' => $request->id_rekap_overtime,
            'jumlah_act_overtime_minggu_1' => $request->jumlah_act_overtime_minggu_1 ?? 0,
            'jumlah_convert_overtime_minggu_1' => $request->jumlah_convert_overtime_minggu_1 ?? 0,
            'jumlah_act_overtime_minggu_2' => $request->jumlah_act_overtime_minggu_2 ?? 0,
            'jumlah_convert_overtime_minggu_2' => $request->jumlah_convert_overtime_minggu_2 ?? 0,
            'jumlah_act_overtime_minggu_3' => $request->jumlah_act_overtime_minggu_3 ?? 0,
            'jumlah_convert_overtime_minggu_3' => $request->jumlah_convert_overtime_minggu_3 ?? 0,
            'jumlah_act_overtime_minggu_4' => $request->jumlah_act_overtime_minggu_4 ?? 0,
            'jumlah_convert_overtime_minggu_4' => $request->jumlah_convert_overtime_minggu_4 ?? 0,
            'jumlah_act_overtime_minggu_5' => $request->jumlah_act_overtime_minggu_5 ?? 0,
            'jumlah_convert_overtime_minggu_5' => $request->jumlah_convert_overtime_minggu_5 ?? 0,
        ]);

        return redirect()->route('dataOvertime.index', $request->id_rekap_overtime)
            ->with('success', 'Data overtime berhasil ditambahkan');
    }

    public function update(Request $request, $id_data_overtime)
    {
        // Validasi input
        $request->validate([
            'jumlah_act_overtime_minggu_1' => 'nullable|numeric',
            'jumlah_convert_overtime_minggu_1' => 'nullable|numeric',
            'jumlah_act_overtime_minggu_2' => 'nullable|numeric',
            'jumlah_convert_overtime_minggu_2' => 'nullable|numeric',
            'jumlah_act_overtime_minggu_3' => 'nullable|numeric',
            'jumlah_convert_overtime_minggu_3' => 'nullable|numeric',
            'jumlah_act_overtime_minggu_4' => 'nullable|numeric',
            'jumlah_convert_overtime_minggu_4' => 'nullable|numeric',
            'jumlah_act_overtime_minggu_5' => 'nullable|numeric',
            'jumlah_convert_overtime_minggu_5' => 'nullable|numeric',
        ]);

        // Cari data yang akan diupdate
        $dataOvertime = SipekaDataOvertime::findOrFail($id_data_overtime);

        // Update data
        $dataOvertime->update([
            'jumlah_act_overtime_minggu_1' => $request->jumlah_act_overtime_minggu_1 ?? 0,
            'jumlah_convert_overtime_minggu_1' => $request->jumlah_convert_overtime_minggu_1 ?? 0,
            'jumlah_act_overtime_minggu_2' => $request->jumlah_act_overtime_minggu_2 ?? 0,
            'jumlah_convert_overtime_minggu_2' => $request->jumlah_convert_overtime_minggu_2 ?? 0,
            'jumlah_act_overtime_minggu_3' => $request->jumlah_act_overtime_minggu_3 ?? 0,
            'jumlah_convert_overtime_minggu_3' => $request->jumlah_convert_overtime_minggu_3 ?? 0,
            'jumlah_act_overtime_minggu_4' => $request->jumlah_act_overtime_minggu_4 ?? 0,
            'jumlah_convert_overtime_minggu_4' => $request->jumlah_convert_overtime_minggu_4 ?? 0,
            'jumlah_act_overtime_minggu_5' => $request->jumlah_act_overtime_minggu_5 ?? 0,
            'jumlah_convert_overtime_minggu_5' => $request->jumlah_convert_overtime_minggu_5 ?? 0,
        ]);

        return redirect()->route('dataOvertime.index', $dataOvertime->id_rekap_overtime)
            ->with('success', 'Data overtime berhasil diperbarui');
    }

    public function destroy($id_data_overtime)
    {
        try {
            // Temukan data overtime berdasarkan ID
            $dataOvertime = SipekaDataOvertime::findOrFail($id_data_overtime);

            // Hapus data overtime
            $dataOvertime->delete();

            // Log penghapusan
            Log::info('Data overtime berhasil dihapus', ['id' => $dataOvertime->id_data_overtime]);

            // Redirect dengan pesan sukses
            return redirect()->route('dataOvertime.index', ['id_rekap_overtime' => $dataOvertime->id_rekap_overtime])
                ->with('success', 'Data overtime berhasil dihapus.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error saat menghapus data overtime', ['error' => $e->getMessage()]);

            // Redirect dengan pesan error
            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

}
