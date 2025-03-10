<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaJatahAbsensi extends Model
{
    use HasFactory;

    protected $table = 'sipeka_jatah_absensi';
    protected $primaryKey = 'id_jatah_absensi';
    public $incrementing = true;
    protected $fillable = [
        'id_pengguna',
        'total_jatah_absensi',
        'tanggal_bergabung',
    ];

    // Relasi ke model M_Pengguna
    public function pengguna()
    {
        return $this->belongsTo(SipekaPengguna::class, 'id_pengguna');
    }

    public function departemen()
    {
        return $this->belongsTo(SipekaDepartemen::class, 'id_departemen');
    }
}
