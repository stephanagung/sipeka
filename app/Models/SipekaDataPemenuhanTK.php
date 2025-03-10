<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SipekaRekapPemenuhanTK;
use App\Models\SipekaDepartemen;

class SipekaDataPemenuhanTK extends Model
{
    use HasFactory;

    protected $table = 'sipeka_data_pemenuhan_tk';
    protected $primaryKey = 'id_data_pemenuhan_tk';
    public $incrementing = true;

    protected $fillable = [
        'id_rekap_pemenuhan_tk',
        'id_departemen',
        'posisi_tk',
        'jumlah_plan_pemenuhan_tk',
        'jumlah_act_pemenuhan_tk',
        'tanggal_pemenuhan_tk',
    ];

    public function rekapPemenuhanTK()
    {
        return $this->belongsTo(SipekaRekapPemenuhanTK::class, 'id_rekap_pemenuhan_tk');
    }

    public function departemen()
    {
        return $this->belongsTo(SipekaDepartemen::class, 'id_departemen');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($dataPemenuhanTK) {
            $dataPemenuhanTK->updateRekapPemenuhanTK();
        });

        static::updated(function ($dataPemenuhanTK) {
            $dataPemenuhanTK->updateRekapPemenuhanTK();
        });

        static::deleted(function ($dataPemenuhanTK) {
            $dataPemenuhanTK->updateRekapPemenuhanTK();
        });
    }

    public function updateRekapPemenuhanTK()
    {
        $rekapPemenuhanTK = SipekaRekapPemenuhanTK::find($this->id_rekap_pemenuhan_tk);

        if ($rekapPemenuhanTK) {
            $totalPlanPemenuhanTK = SipekaDataPemenuhanTK::where('id_rekap_pemenuhan_tk', $this->id_rekap_pemenuhan_tk)->sum('jumlah_plan_pemenuhan_tk');
            $totalActPemenuhanTK = SipekaDataPemenuhanTK::where('id_rekap_pemenuhan_tk', $this->id_rekap_pemenuhan_tk)->sum('jumlah_act_pemenuhan_tk');

            $rekapPemenuhanTK->update([
                'total_plan_pemenuhan_tk' => $totalPlanPemenuhanTK,
                'total_act_pemenuhan_tk' => $totalActPemenuhanTK,
            ]);
        }
    }
}
