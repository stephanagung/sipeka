<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SipekaRekapPelatihan;

class SipekaDataPelatihan extends Model
{
    use HasFactory;

    protected $table = 'sipeka_data_pelatihan';
    protected $primaryKey = 'id_data_pelatihan';
    public $incrementing = true;

    protected $fillable = [
        'id_rekap_pelatihan',
        'id_departemen',
        'nama_pelatihan',
        'jumlah_plan_partisipan',
        'jumlah_act_partisipan',
        'tanggal_pelatihan'
    ];

    public function rekapPelatihan()
    {
        return $this->belongsTo(SipekaRekapPelatihan::class, 'id_rekap_pelatihan');
    }

    // Relasi ke model SipekaDepartemen
    public function departemen()
    {
        return $this->belongsTo(SipekaDepartemen::class, 'id_departemen');
    }

    public function plant()
    {
        return $this->rekapPelatihan->plant();
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($dataPelatihan) {
            $dataPelatihan->updateTotalPelatihan();
        });

        static::updated(function ($dataPelatihan) {
            $dataPelatihan->updateTotalPelatihan();
        });

        static::deleted(function ($dataPelatihan) {
            $dataPelatihan->updateTotalPelatihan();
        });
    }

    public function updateTotalPelatihan()
    {
        $rekapPelatihan = SipekaRekapPelatihan::find($this->id_rekap_pelatihan);

        if ($rekapPelatihan) {
            // Hitung total pelatihan berdasarkan jumlah data pelatihan
            $totalActPelatihan = SipekaDataPelatihan::where('id_rekap_pelatihan', $this->id_rekap_pelatihan)->count();
            $totalPlanPartisipan = SipekaDataPelatihan::where('id_rekap_pelatihan', $this->id_rekap_pelatihan)->sum('jumlah_plan_partisipan');
            $totalActPartisipan = SipekaDataPelatihan::where('id_rekap_pelatihan', $this->id_rekap_pelatihan)->sum('jumlah_act_partisipan');

            // Update nilai di rekap pelatihan
            $rekapPelatihan->update([
                'total_act_pelatihan' => $totalActPelatihan,
                'total_plan_partisipan' => $totalPlanPartisipan,
                'total_act_partisipan' => $totalActPartisipan
            ]);
        }
    }
}
