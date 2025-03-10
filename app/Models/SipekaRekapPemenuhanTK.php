<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaRekapPemenuhanTK extends Model
{
    use HasFactory;

    protected $table = 'sipeka_rekap_pemenuhan_tk';
    protected $primaryKey = 'id_rekap_pemenuhan_tk';
    public $incrementing = true;

    protected $fillable = [
        'id_plant',
        'total_plan_pemenuhan_tk',
        'total_act_pemenuhan_tk',
        'periode_bulan_pemenuhan_tk',
        'periode_tahun_pemenuhan_tk',
    ];

    public function plant()
    {
        return $this->belongsTo(SipekaPlant::class, 'id_plant');
    }

    public function dataPemenuhanTK()
    {
        return $this->hasMany(SipekaDataPemenuhanTK::class, 'id_rekap_pemenuhan_tk');
    }

    public function getTotalPlanPemenuhanTkAttribute()
    {
        return $this->dataPemenuhanTK()->sum('jumlah_plan_pemenuhan_tk');
    }

    public function getTotalActPemenuhanTkAttribute()
    {
        return $this->dataPemenuhanTK()->sum('jumlah_act_pemenuhan_tk');
    }
}
