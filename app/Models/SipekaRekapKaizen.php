<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaRekapKaizen extends Model
{
    use HasFactory;

    protected $table = 'sipeka_rekap_kaizen';
    protected $primaryKey = 'id_rekap_kaizen';
    public $incrementing = true; // Menandakan bahwa kolom primary key auto increment
    protected $fillable = [
        'id_plant',
        'total_kaizen',
        'periode_bulan_kaizen',
        'periode_tahun_kaizen',
    ];


    // Relasi ke Plant
    public function plant()
    {
        return $this->belongsTo(SipekaPlant::class, 'id_plant');
    }

    // Relasi ke Departemen
    public function departemen()
    {
        return $this->belongsTo(SipekaDepartemen::class, 'id_departemen');
    }

    // SipekaRekapKaizen.php
    public function dataKaizen()
    {
        return $this->hasMany(SipekaDataKaizen::class, 'id_rekap_kaizen');
    }

}
