<?php
// SipekaDataKaizen.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SipekaRekapKaizen;

class SipekaDataKaizen extends Model
{
    use HasFactory;

    protected $table = 'sipeka_data_kaizen';
    protected $primaryKey = 'id_data_kaizen';
    public $incrementing = true;
    protected $fillable = [
        'id_rekap_kaizen',
        'id_pengguna',
        'nama_kaizen',
        'jumlah_kaizen',
        'tanggal_penerbitan_kaizen'
    ];

    public static function boot()
    {
        parent::boot();

        // Event setelah data Kaizen ditambahkan
        static::created(function ($dataKaizen) {
            $dataKaizen->updateTotalKaizen();
        });

        // Event setelah data Kaizen diperbarui
        static::updated(function ($dataKaizen) {
            $dataKaizen->updateTotalKaizen();
        });

        // Event setelah data Kaizen dihapus
        static::deleted(function ($dataKaizen) {
            $dataKaizen->updateTotalKaizen();
        });
    }

    // Fungsi untuk mengupdate total kaizen di Rekap Kaizen
    public function updateTotalKaizen()
    {
        // Cari rekap kaizen terkait
        $rekapKaizen = SipekaRekapKaizen::find($this->id_rekap_kaizen);

        if ($rekapKaizen) {
            // Hitung jumlah total kaizen
            $totalKaizen = SipekaDataKaizen::where('id_rekap_kaizen', $this->id_rekap_kaizen)
                ->sum('jumlah_kaizen');

            // Update kolom total_kaizen di rekap kaizen
            $rekapKaizen->update([
                'total_kaizen' => $totalKaizen
            ]);
        }
    }

    // Relasi ke Pengguna (User)
    public function pengguna()
    {
        return $this->belongsTo(SipekaPengguna::class, 'id_pengguna');
    }

    // SipekaDataKaizen.php
    public function rekapKaizen()
    {
        return $this->belongsTo(SipekaRekapKaizen::class, 'id_rekap_kaizen');
    }

}
