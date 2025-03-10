<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SipekaRekapAsesmenPrd;

class SipekaDataAsesmenPrd extends Model
{
    use HasFactory;

    // Define table name if not default
    protected $table = 'sipeka_data_asesmen_prd';

    protected $primaryKey = 'id_data_asesmen_prd';

    public $incrementing = true;

    // Specify fillable fields to allow mass assignment
    protected $fillable = [
        'id_rekap_asesmen_prd',
        'grup_asesmen',
        'jumlah_plan_asesmen',
        'jumlah_act_asesmen',
    ];

    public static function boot()
    {
        parent::boot();

        // Event setelah data Asesmen ditambahkan
        static::created(function ($dataAsesmen) {
            $dataAsesmen->updateTotalAsesmenPrd();
        });

        // Event setelah data Asesmen diperbarui
        static::updated(function ($dataAsesmen) {
            $dataAsesmen->updateTotalAsesmenPrd();
        });

        // Event setelah data Asesmen dihapus
        static::deleted(function ($dataAsesmen) {
            $dataAsesmen->updateTotalAsesmenPrd();
        });
    }

    // Fungsi untuk mengupdate total_plan_asesmen_prd dan total_actual_asesmen_prd di Rekap Asesmen
    public function updateTotalAsesmenPrd()
    {
        // Cari rekap asesmen terkait
        $rekapAsesmen = SipekaRekapAsesmenPrd::find($this->id_rekap_asesmen_prd);

        if ($rekapAsesmen) {
            // Hitung jumlah total plan asesmen
            $totalPlanAsesmen = SipekaDataAsesmenPrd::where('id_rekap_asesmen_prd', $this->id_rekap_asesmen_prd)
                ->sum('jumlah_plan_asesmen');

            // Hitung jumlah total actual asesmen
            $totalActualAsesmen = SipekaDataAsesmenPrd::where('id_rekap_asesmen_prd', $this->id_rekap_asesmen_prd)
                ->sum('jumlah_act_asesmen');

            // Update kolom total_plan_asesmen_prd dan total_actual_asesmen_prd di rekap asesmen
            $rekapAsesmen->update([
                'total_plan_asesmen_prd' => $totalPlanAsesmen,
                'total_actual_asesmen_prd' => $totalActualAsesmen
            ]);
        }
    }

    // Relasi ke Rekap Asesmen
    public function rekapAsesmenPrd()
    {
        return $this->belongsTo(SipekaRekapAsesmenPrd::class, 'id_rekap_asesmen_prd');
    }

    public function plant()
    {
        return $this->rekapAsesmenPrd->plant();
    }
}
