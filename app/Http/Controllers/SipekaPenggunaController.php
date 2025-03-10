<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SipekaPengguna;
use App\Models\SipekaDepartemen;
use App\Models\SipekaPlant;
use App\Models\SipekaJatahAbsensi;
use App\Imports\PenggunaImport;
use Maatwebsite\Excel\Facades\Excel;

class SipekaPenggunaController extends Controller
{
    public function index()
    {
        $pengguna = SipekaPengguna::with(['departemen', 'plant'])->get();
        $departemen = SipekaDepartemen::all();
        $plants = SipekaPlant::all();
        return view('master-data.index-pengguna', compact('pengguna', 'departemen', 'plants'));
    }

    public function store(Request $request)
    {
        // Validasi dan proses penyimpanan pengguna
        $pengguna = SipekaPengguna::create([
            'id_departemen' => $request->id_departemen,
            'id_plant' => $request->id_plant,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'domisili' => $request->domisili,
            'jenis_lemburan' => $request->jenis_lemburan,
            'status_pekerjaan' => $request->status_pekerjaan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'username' => $request->username,
            'password' => $request->password,
            'level' => $request->level,
        ]);

        // Perhitungan dan penyimpanan jatah absensi
        $tanggalBergabung = $request->tanggal_bergabung;
        $tanggalSekarang = now();
        $selisihBulan = $tanggalSekarang->diffInMonths($tanggalBergabung);
        $totalJatahAbsensi = $selisihBulan >= 12 ? 1 : 0;

        $jatahAbsensi = SipekaJatahAbsensi::create([
            'id_pengguna' => $pengguna->id_pengguna,
            'total_jatah_absensi' => $totalJatahAbsensi,
            'tanggal_bergabung' => $tanggalBergabung,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, $id_pengguna)
    {
        $request->validate([
            'id_departemen' => 'required|exists:sipeka_departemen,id_departemen',
            'id_plant' => 'required|exists:sipeka_plant,id_plant',
            'nik' => 'required',
            'nama_lengkap' => 'required',
            'jabatan' => 'required',
            'domisili' => 'required',
            'jenis_lemburan' => 'required|in:Flat,NonFlat',
            'status_pekerjaan' => 'required|in:Tetap,Kontrak,Magang/pkl',
            'pendidikan_terakhir' => 'required|in:SD,SMP,SMA,SMK,D1,D2,D3,D4,S1,S2,S3',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'username' => 'nullable|unique:sipeka_pengguna,username,' . $id_pengguna . ',id_pengguna',
            'password' => 'nullable',
            'level' => 'nullable|in:Admin,Atasan,Karyawan',
        ]);

        $pengguna = SipekaPengguna::findOrFail($id_pengguna);
        $pengguna->update([
            'id_departemen' => $request->id_departemen,
            'id_plant' => $request->id_plant,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan' => $request->jabatan,
            'domisili' => $request->domisili,
            'jenis_lemburan' => $request->jenis_lemburan,
            'status_pekerjaan' => $request->status_pekerjaan,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'username' => $request->username,
            'password' => $request->password,
            'level' => $request->level ? $request->level : $pengguna->level,
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id_pengguna)
    {
        $pengguna = SipekaPengguna::findOrFail($id_pengguna);
        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil dihapus.');
    }

    public function show($id_pengguna)
    {
        $pengguna = SipekaPengguna::with(['departemen', 'plant'])->findOrFail($id_pengguna);
        return view('master-data.detail-pengguna', compact('pengguna'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new PenggunaImport, $request->file('file'));

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diimport.');
    }
}
