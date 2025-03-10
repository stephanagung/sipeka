<?php

namespace App\Imports;

use App\Models\SipekaPengguna;
use App\Models\SipekaJatahAbsensi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenggunaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['id_departemen']) || empty($row['id_plant'])) {
            return null; // Skip baris jika id_departemen atau id_plant kosong
        }

        $pengguna = SipekaPengguna::create([
            'id_departemen' => $row['id_departemen'],
            'id_plant' => $row['id_plant'],
            'nik' => $row['nik'],
            'nama_lengkap' => $row['nama_lengkap'],
            'jabatan' => $row['jabatan'],
            'domisili' => $row['domisili'],
            'jenis_lemburan' => $row['jenis_lemburan'],
            'status_pekerjaan' => $row['status_pekerjaan'],
            'pendidikan_terakhir' => $row['pendidikan_terakhir'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'username' => $row['username'],
            'password' => $row['password'], // Tanpa hash
            'level' => $row['level'],
        ]);

        $tanggalBergabung = $row['tanggal_bergabung'];
        $tanggalSekarang = now();
        $selisihBulan = $tanggalSekarang->diffInMonths($tanggalBergabung);
        $totalJatahAbsensi = $selisihBulan >= 12 ? 1 : 0;

        SipekaJatahAbsensi::create([
            'id_pengguna' => $pengguna->id_pengguna,
            'total_jatah_absensi' => $totalJatahAbsensi,
            'tanggal_bergabung' => $tanggalBergabung,
        ]);

        return $pengguna;
    }

}
