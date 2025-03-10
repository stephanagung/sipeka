<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaRekapPelatihan extends Model
{
    use HasFactory;

    protected $table = 'sipeka_rekap_pelatihan';
    protected $primaryKey = 'id_rekap_pelatihan';
    public $incrementing = true;

    protected $fillable = [
        'id_plant',
        'total_plan_pelatihan',
        'total_act_pelatihan',
        'total_plan_partisipan',
        'total_act_partisipan',
        'periode_bulan_pelatihan',
        'periode_tahun_pelatihan'
    ];

    public function plant()
    {
        return $this->belongsTo(SipekaPlant::class, 'id_plant');
    }

    public function dataPelatihan()
    {
        return $this->hasMany(SipekaDataPelatihan::class, 'id_rekap_pelatihan');
    }

    public function getTotalActPelatihanAttribute()
    {
        return $this->dataPelatihan()->count();
    }

    public function getTotalPlanPartisipanAttribute()
    {
        return $this->dataPelatihan()->sum('jumlah_plan_partisipan');
    }

    public function getTotalActPartisipanAttribute()
    {
        return $this->dataPelatihan()->sum('jumlah_act_partisipan');
    }
}
