<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaDataKecelakaan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan default
    protected $table = 'sipeka_data_kecelakaan';

    // Tentukan primary key
    protected $primaryKey = 'id_data_kecelakaan';

    // Tentukan bahwa primary key auto increment
    public $incrementing = true;

    // Tentukan atribut yang bisa diisi secara massal
    protected $fillable = [
        'id_rekap_kecelakaan',
        'id_departemen',
        'nama_kecelakaan',
        'jumlah_korban_kecelakaan',
        'deskripsi_kecelakaan',
        'tanggal_kecelakaan'
    ];

    // Relasi ke SipekaRekapKecelakaan (Many to One)
    public function rekapKecelakaan()
    {
        return $this->belongsTo(SipekaRekapKecelakaan::class, 'id_rekap_kecelakaan');
    }

    // Relasi ke SipekaDepartemen (Many to One)
    public function departemen()
    {
        return $this->belongsTo(SipekaDepartemen::class, 'id_departemen');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($dataKecelakaan) {
            $dataKecelakaan->updateRekapKecelakaan();
        });

        static::updated(function ($dataKecelakaan) {
            $dataKecelakaan->updateRekapKecelakaan();
        });

        static::deleted(function ($dataKecelakaan) {
            $dataKecelakaan->updateRekapKecelakaan();
        });
    }

    public function updateRekapKecelakaan()
    {
        $rekapKecelakaan = SipekaRekapKecelakaan::find($this->id_rekap_kecelakaan);

        if ($rekapKecelakaan) {
            $totalKecelakaan = SipekaDataKecelakaan::where('id_rekap_kecelakaan', $this->id_rekap_kecelakaan)->count();
            $totalKorbanKecelakaan = SipekaDataKecelakaan::where('id_rekap_kecelakaan', $this->id_rekap_kecelakaan)->sum('jumlah_korban_kecelakaan');

            $rekapKecelakaan->update([
                'total_kecelakaan' => $totalKecelakaan,
                'total_korban_kecelakaan' => $totalKorbanKecelakaan
            ]);
        }
    }
}
