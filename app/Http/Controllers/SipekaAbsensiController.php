<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\SipekaAbsensi;
use App\Models\SipekaJatahAbsensi;
use App\Models\SipekaKategoriAbsensi;
use App\Models\SipekaDepartemen;
use App\Models\SipekaPlant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SipekaAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $departemen = SipekaDepartemen::all(); // Ambil semua departemen
        $plants = SipekaPlant::all(); // Ambil semua plant

        // Query awal untuk jatahAbsensi dan absensi
        $jatahAbsensiQuery = SipekaJatahAbsensi::with('pengguna.departemen', 'pengguna.plant');
        $absensiQuery = SipekaAbsensi::with(['kategori', 'jatahAbsensi.pengguna']);

        // Filter berdasarkan Departemen
        if ($request->has('departemen_id') && $request->input('departemen_id') != '') {
            $departemenId = $request->input('departemen_id');

            $jatahAbsensiQuery->whereHas('pengguna', function ($query) use ($departemenId) {
                $query->where('id_departemen', $departemenId);
            });

            $absensiQuery->whereHas('jatahAbsensi.pengguna', function ($query) use ($departemenId) {
                $query->where('id_departemen', $departemenId);
            });
        }

        // Filter berdasarkan Plant
        if ($request->has('plant_id') && $request->input('plant_id') != '') {
            $plantId = $request->input('plant_id');

            $jatahAbsensiQuery->whereHas('pengguna', function ($query) use ($plantId) {
                $query->where('id_plant', $plantId);
            });

            $absensiQuery->whereHas('jatahAbsensi.pengguna', function ($query) use ($plantId) {
                $query->where('id_plant', $plantId);
            });
        }

        // Eksekusi query setelah semua filter diterapkan
        $jatahAbsensi = $jatahAbsensiQuery->get();
        $absensi = $absensiQuery->get();
        $kategori = SipekaKategoriAbsensi::all(); // Fetch all kategori for the dropdown

        return view('absensi.index-absensi', compact('jatahAbsensi', 'absensi', 'kategori', 'departemen', 'plants'));
    }

    public function show($id_absensi)
    {
        $absensi = SipekaAbsensi::with(['jatahAbsensi.pengguna.departemen', 'kategori'])
            ->find($id_absensi);

        if (!$absensi) {
            return redirect()->route('absensi.index')->withErrors(['error' => 'Data absensi tidak ditemukan.']);
        }

        return view('absensi.index-info-absensi', compact('absensi'));
    }

    public function store(Request $request)
    {
        // Validasi input data
        $validatedData = $request->validate([
            'id_jatah_absensi' => 'required|exists:sipeka_jatah_absensi,id_jatah_absensi',
            'id_kategori_absensi' => 'required|exists:sipeka_kategori_absensi,id_kategori_absensi',
            'shift' => 'required|in:1,2,3',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'status_absensi' => 'required|integer',
            'tanggal_absen' => 'nullable|date_format:Y-m-d\TH:i',
            'tanggal_absensi_mulai' => 'nullable|date_format:Y-m-d\TH:i',
            'tanggal_absensi_akhir' => 'required|date_format:Y-m-d\TH:i|after_or_equal:tanggal_absensi_mulai',
            'jumlah_absensi' => 'nullable|integer',
            'alasan' => 'required|string',
            'catatan' => 'nullable|string',
            'disetujui_atasan' => 'nullable|integer',
            'disetujui_hrd' => 'nullable|integer',
        ], [
            'tanggal_absensi_akhir.after_or_equal' => 'Tanggal akhir absensi tidak boleh sebelum tanggal mulai absensi.',
        ]);

        // Ambil informasi kategori berdasarkan id_kategori_absensi
        $kategori = SipekaKategoriAbsensi::find($validatedData['id_kategori_absensi']);
        if (!$kategori) {
            return redirect()->back()->withErrors(['error' => 'Kategori absensi tidak ditemukan.']);
        }

        // Tentukan apakah kolom tanggal_absen digunakan
        if (
            in_array($kategori->id_kategori_absensi, [6, 8, 11]) ||
            in_array($kategori->nama_kategori_absensi, ["MANGKIR", "TERLAMBAT", "PULANG CEPAT"]) ||
            in_array($kategori->kode_kategori_absensi, ["A", "LI", "PC"])
        ) {

            // Tanggal Absen digunakan untuk mengisi tanggal_absensi_mulai dan tanggal_absensi_akhir
            $timezone = 'Asia/Jakarta';
            $validatedData['tanggal_absensi_mulai'] = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['tanggal_absen'], $timezone)->format('Y-m-d H:i:s');
            $validatedData['tanggal_absensi_akhir'] = $validatedData['tanggal_absensi_mulai'];

            // Kondisi untuk jumlah_absensi
            if ($kategori->id_kategori_absensi == 8 || $kategori->id_kategori_absensi == 11) {
                $validatedData['jumlah_absensi'] = 0;
            } elseif ($kategori->id_kategori_absensi == 6) {
                $validatedData['jumlah_absensi'] = 1;
            }
        } else {
            // Konversi tanggal dari input dengan timezone lokal
            $timezone = 'Asia/Jakarta';
            $validatedData['tanggal_absensi_mulai'] = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['tanggal_absensi_mulai'], $timezone)->format('Y-m-d H:i:s');
            $validatedData['tanggal_absensi_akhir'] = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['tanggal_absensi_akhir'], $timezone)->format('Y-m-d H:i:s');

            // Hitung jumlah hari absensi
            $tanggalMulai = Carbon::parse($validatedData['tanggal_absensi_mulai']);
            $tanggalAkhir = Carbon::parse($validatedData['tanggal_absensi_akhir']);

            // Selisih hari absensi, ditambah 1 agar inklusif
            $validatedData['jumlah_absensi'] = $tanggalMulai->diffInDays($tanggalAkhir) + 1;
        }

        // Simpan data absensi
        $absensi = SipekaAbsensi::create($validatedData);

        // Ambil jatah absensi berdasarkan ID
        $jatahAbsensi = SipekaJatahAbsensi::with('pengguna.departemen')->find($validatedData['id_jatah_absensi']);
        if (!$jatahAbsensi || !$jatahAbsensi->pengguna || !$jatahAbsensi->pengguna->departemen) {
            return redirect()->back()->withErrors(['error' => 'Pengguna atau departemen tidak ditemukan.']);
        }

        $pengguna = $jatahAbsensi->pengguna;
        $departemen = $pengguna->departemen;

        // Penamaan file
        if ($request->hasFile('dokumen_pendukung')) {
            $file = $request->file('dokumen_pendukung');
            $fileName = str_replace(' ', '_', "{$pengguna->nama_lengkap}_{$pengguna->nik}_{$departemen->kode_departemen}_{$kategori->kode_kategori_absensi}") . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/dokumen_absensi', $fileName);

            // Simpan path yang benar ke database
            $validatedData['dokumen_pendukung'] = "dokumen_absensi/{$fileName}";

            // Update data absensi dengan path file
            $absensi->update(['dokumen_pendukung' => $validatedData['dokumen_pendukung']]);
        }

        // Kurangi jatah absensi jika kategori adalah "CUTI TAHUNAN"
        if ($kategori->id_kategori_absensi == 9 && $kategori->kode_kategori_absensi == 'C' && $kategori->nama_kategori_absensi == 'CUTI TAHUNAN') {
            $jatahAbsensi->total_jatah_absensi -= $validatedData['jumlah_absensi'];
            $jatahAbsensi->save();
        }

        return redirect()->back()->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function update(Request $request, $id_absensi)
    {
        $absensi = SipekaAbsensi::findOrFail($id_absensi);

        // Validasi input
        $validatedData = $request->validate([
            'shift' => 'required|in:1,2,3',
            'tanggal_absensi_mulai' => 'required|date_format:Y-m-d\TH:i',
            'tanggal_absensi_akhir' => 'required|date_format:Y-m-d\TH:i|after_or_equal:tanggal_absensi_mulai',
            'alasan' => 'required|string',
            'catatan' => 'nullable|string',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ], [
            'tanggal_absensi_akhir.after_or_equal' => 'Tanggal akhir absensi tidak boleh sebelum tanggal mulai absensi.',
        ]);

        // Konversi tanggal ke format database
        $timezone = 'Asia/Jakarta';
        $validatedData['tanggal_absensi_mulai'] = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['tanggal_absensi_mulai'], $timezone)->format('Y-m-d H:i:s');
        $validatedData['tanggal_absensi_akhir'] = Carbon::createFromFormat('Y-m-d\TH:i', $validatedData['tanggal_absensi_akhir'], $timezone)->format('Y-m-d H:i:s');

        // Hitung jumlah hari absensi
        $tanggalMulai = Carbon::parse($validatedData['tanggal_absensi_mulai']);
        $tanggalAkhir = Carbon::parse($validatedData['tanggal_absensi_akhir']);
        $validatedData['jumlah_absensi'] = $tanggalMulai->diffInDays($tanggalAkhir) + 1;

        // Ambil data jatah absensi & kategori
        $jatahAbsensi = $absensi->jatahAbsensi;
        $kategori = $absensi->kategori;

        if (!$jatahAbsensi || !$kategori) {
            return redirect()->back()->withErrors(['error' => 'Data absensi tidak ditemukan.']);
        }

        // Cek apakah absensi adalah CUTI TAHUNAN
        if ($kategori->id_kategori_absensi == 9 && $kategori->kode_kategori_absensi == 'C' && $kategori->nama_kategori_absensi == 'CUTI TAHUNAN') {
            $jumlahAbsensiSebelumnya = $absensi->jumlah_absensi;
            $jumlahAbsensiBaru = $validatedData['jumlah_absensi'];

            // Jika jumlah cuti baru lebih kecil, tambahkan kembali selisih ke total jatah absensi
            if ($jumlahAbsensiBaru < $jumlahAbsensiSebelumnya) {
                $jatahAbsensi->total_jatah_absensi += ($jumlahAbsensiSebelumnya - $jumlahAbsensiBaru);
            }
            // Jika jumlah cuti baru lebih besar, kurangi dari total jatah absensi
            elseif ($jumlahAbsensiBaru > $jumlahAbsensiSebelumnya) {
                $jatahAbsensi->total_jatah_absensi -= ($jumlahAbsensiBaru - $jumlahAbsensiSebelumnya);
            }

            $jatahAbsensi->save();
        }

        // Cek jika ada file baru yang diunggah
        if ($request->hasFile('dokumen_pendukung')) {
            // Hapus file lama jika ada
            if ($absensi->dokumen_pendukung) {
                Storage::delete('public/' . $absensi->dokumen_pendukung);
            }

            // Simpan file baru
            $file = $request->file('dokumen_pendukung');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/dokumen_absensi', $fileName);
            $validatedData['dokumen_pendukung'] = "dokumen_absensi/{$fileName}";
        }

        // Update data absensi
        $absensi->update($validatedData);

        return redirect()->back()->with('success', 'Data absensi berhasil diperbarui.');
    }


    public function destroy($id_absensi)
    {
        $absensi = SipekaAbsensi::findOrFail($id_absensi);

        // Cek apakah kategori absensi adalah CUTI TAHUNAN
        $kategori = $absensi->kategori;
        if (
            $kategori &&
            $kategori->id_kategori_absensi == 9 &&
            $kategori->kode_kategori_absensi == 'C' &&
            $kategori->nama_kategori_absensi == 'CUTI TAHUNAN'
        ) {
            // Ambil data jatah absensi
            $jatahAbsensi = $absensi->jatahAbsensi;
            if ($jatahAbsensi) {
                // Kembalikan jumlah absensi yang dipotong ke total jatah absensi
                $jatahAbsensi->total_jatah_absensi += $absensi->jumlah_absensi;
                $jatahAbsensi->save();
            }
        }

        // Hapus file dokumen jika ada
        if ($absensi->dokumen_pendukung) {
            $filePath = 'public/' . $absensi->dokumen_pendukung;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
        }

        // Hapus data absensi
        $absensi->delete();

        return redirect()->back()->with('success', 'Data absensi berhasil dihapus dan jatah absensi dikembalikan jika berlaku.');
    }

}
