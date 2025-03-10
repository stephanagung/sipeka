<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaAbsensi extends Model
{
    use HasFactory;

    protected $table = 'sipeka_absensi';

    protected $primaryKey = 'id_absensi';

    protected $fillable = [
        'id_jatah_absensi',
        'id_kategori_absensi',
        'shift',
        'dokumen_pendukung',
        'status_absensi',
        'tanggal_absensi_mulai',
        'tanggal_absensi_akhir',
        'jumlah_absensi',
        'alasan',
        'catatan',
        'disetujui_atasan',
        'disetujui_hrd'
    ];

    public function jatahAbsensi()
    {
        return $this->belongsTo(SipekaJatahAbsensi::class, 'id_jatah_absensi');
    }

    public function kategori()
    {
        return $this->belongsTo(SipekaKategoriAbsensi::class, 'id_kategori_absensi');
    }
}
