<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaRekapKecelakaan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan default
    protected $table = 'sipeka_rekap_kecelakaan';

    // Tentukan primary key
    protected $primaryKey = 'id_rekap_kecelakaan';

    // Tentukan bahwa primary key auto increment
    public $incrementing = true;

    // Tentukan atribut yang bisa diisi secara massal
    protected $fillable = [
        'id_plant',
        'total_kecelakaan',
        'total_korban_kecelakaan',
        'periode_bulan_kecelakaan',
        'periode_tahun_kecelakaan'
    ];

    // Relasi ke tabel SipekaPlant (One to Many)
    public function plant()
    {
        return $this->belongsTo(SipekaPlant::class, 'id_plant');
    }

    // Relasi ke tabel SipekaDataKecelakaan (One to Many)
    public function dataKecelakaan()
    {
        return $this->hasMany(SipekaDataKecelakaan::class, 'id_rekap_kecelakaan');
    }

    // Menghitung total kecelakaan berdasarkan jumlah data kecelakaan
    public function getTotalKecelakaanAttribute()
    {
        return $this->dataKecelakaan()->count();
    }

    // Menghitung total korban kecelakaan berdasarkan jumlah_korban_kecelakaan
    public function getTotalKorbanKecelakaanAttribute()
    {
        return $this->dataKecelakaan()->sum('jumlah_korban_kecelakaan');
    }
}
