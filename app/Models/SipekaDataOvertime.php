<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SipekaRekapOvertime;

class SipekaDataOvertime extends Model
{
    use HasFactory;

    protected $table = 'sipeka_data_overtime';
    protected $primaryKey = 'id_data_overtime';
    public $incrementing = true;

    protected $fillable = [
        'id_rekap_overtime',
        'jumlah_act_overtime_minggu_1',
        'jumlah_convert_overtime_minggu_1',
        'jumlah_act_overtime_minggu_2',
        'jumlah_convert_overtime_minggu_2',
        'jumlah_act_overtime_minggu_3',
        'jumlah_convert_overtime_minggu_3',
        'jumlah_act_overtime_minggu_4',
        'jumlah_convert_overtime_minggu_4',
        'jumlah_act_overtime_minggu_5',
        'jumlah_convert_overtime_minggu_5',
    ];

    public function rekapOvertime()
    {
        return $this->belongsTo(SipekaRekapOvertime::class, 'id_rekap_overtime');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($dataOvertime) {
            $dataOvertime->updateRekapOvertime();
        });

        static::updated(function ($dataOvertime) {
            $dataOvertime->updateRekapOvertime();
        });

        static::deleted(function ($dataOvertime) {
            $dataOvertime->updateRekapOvertime();
        });
    }

    public function updateRekapOvertime()
    {
        $rekapOvertime = SipekaRekapOvertime::find($this->id_rekap_overtime);

        if ($rekapOvertime) {
            $totalActOvertime = SipekaDataOvertime::where('id_rekap_overtime', $this->id_rekap_overtime)->sum('jumlah_act_overtime_minggu_1') +
                SipekaDataOvertime::where('id_rekap_overtime', $this->id_rekap_overtime)->sum('jumlah_act_overtime_minggu_2') +
                SipekaDataOvertime::where('id_rekap_overtime', $this->id_rekap_overtime)->sum('jumlah_act_overtime_minggu_3') +
                SipekaDataOvertime::where('id_rekap_overtime', $this->id_rekap_overtime)->sum('jumlah_act_overtime_minggu_4') +
                SipekaDataOvertime::where('id_rekap_overtime', $this->id_rekap_overtime)->sum('jumlah_act_overtime_minggu_5');

            $totalConvertOvertime = SipekaDataOvertime::where('id_rekap_overtime', $this->id_rekap_overtime)->sum('jumlah_convert_overtime_minggu_1') +
                SipekaDataOvertime::where('id_rekap_overtime', $this->id_rekap_overtime)->sum('jumlah_convert_overtime_minggu_2') +
                SipekaDataOvertime::where('id_rekap_overtime', $this->id_rekap_overtime)->sum('jumlah_convert_overtime_minggu_3') +
                SipekaDataOvertime::where('id_rekap_overtime', $this->id_rekap_overtime)->sum('jumlah_convert_overtime_minggu_4') +
                SipekaDataOvertime::where('id_rekap_overtime', $this->id_rekap_overtime)->sum('jumlah_convert_overtime_minggu_5');

            $rekapOvertime->update([
                'total_act_overtime' => $totalActOvertime,
                'total_convert_overtime' => $totalConvertOvertime
            ]);
        }
    }
}
