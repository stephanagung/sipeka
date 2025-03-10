<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaRekapOvertime extends Model
{
    use HasFactory;

    protected $table = 'sipeka_rekap_overtime';
    protected $primaryKey = 'id_rekap_overtime';
    public $incrementing = true;

    protected $fillable = [
        'id_plant',
        'total_act_overtime',
        'total_convert_overtime',
        'periode_bulan_overtime',
        'periode_tahun_overtime',
    ];

    public function plant()
    {
        return $this->belongsTo(SipekaPlant::class, 'id_plant');
    }

    public function dataOvertime()
    {
        return $this->hasMany(SipekaDataOvertime::class, 'id_rekap_overtime');
    }

    // Menghitung total actual overtime dari semua minggu
    public function getTotalActOvertimeAttribute()
    {
        return $this->dataOvertime()->sum('jumlah_act_overtime_minggu_1') +
            $this->dataOvertime()->sum('jumlah_act_overtime_minggu_2') +
            $this->dataOvertime()->sum('jumlah_act_overtime_minggu_3') +
            $this->dataOvertime()->sum('jumlah_act_overtime_minggu_4') +
            $this->dataOvertime()->sum('jumlah_act_overtime_minggu_5');
    }

    // Menghitung total convert overtime dari semua minggu
    public function getTotalConvertOvertimeAttribute()
    {
        return $this->dataOvertime()->sum('jumlah_convert_overtime_minggu_1') +
            $this->dataOvertime()->sum('jumlah_convert_overtime_minggu_2') +
            $this->dataOvertime()->sum('jumlah_convert_overtime_minggu_3') +
            $this->dataOvertime()->sum('jumlah_convert_overtime_minggu_4') +
            $this->dataOvertime()->sum('jumlah_convert_overtime_minggu_5');
    }

}
