<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaRekapAsesmenPrd extends Model
{
    use HasFactory;

    // Define table name if not default
    protected $table = 'sipeka_rekap_asesmen_prd';

    protected $primaryKey = 'id_rekap_asesmen_prd';

    public $incrementing = true; // Menandakan bahwa kolom primary key auto increment

    // Specify fillable fields to allow mass assignment
    protected $fillable = [
        'id_plant',
        'total_plan_asesmen_prd',
        'total_actual_asesmen_prd',
        'periode_bulan_asesmen_prd',
        'periode_tahun_asesmen_prd'
    ];

    // Relasi ke Plant
    public function plant()
    {
        return $this->belongsTo(SipekaPlant::class, 'id_plant');
    }

    // Relasi ke Data Asesmen
    public function dataAsesmenPrd()
    {
        return $this->hasMany(SipekaDataAsesmenPrd::class, 'id_rekap_asesmen_prd');
    }

}
