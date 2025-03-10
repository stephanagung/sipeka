<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaKategoriAbsensi extends Model
{
    use HasFactory;

    protected $table = 'sipeka_kategori_absensi';
    protected $primaryKey = 'id_kategori_absensi';
    public $incrementing = true; // Pastikan ini true untuk auto-increment
    protected $keyType = 'integer'; // Tipe primary key adalah integer

    protected $fillable = ['nama_kategori_absensi', 'kode_kategori_absensi'];

    public function jatahAbsensi()
    {
        return $this->hasMany(SipekaJatahAbsensi::class, 'id_jatah_absensi');
    }
}
