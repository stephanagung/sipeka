<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaPengguna extends Model
{
    use HasFactory;

    protected $table = 'sipeka_pengguna';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = true; // Menandakan bahwa kolom primary key auto increment
    protected $fillable = [
        'id_departemen',
        'id_plant',
        'nik',
        'nama_lengkap',
        'jabatan',
        'domisili',
        'jenis_lemburan',
        'status_pekerjaan',
        'pendidikan_terakhir',
        'jenis_kelamin',
        'username',
        'password',
        'level',
    ];

    public function departemen()
    {
        return $this->belongsTo(SipekaDepartemen::class, 'id_departemen');
    }

    public function plant()
    {
        return $this->belongsTo(SipekaPlant::class, 'id_plant');
    }

    public function jatahAbsensi()
    {
        return $this->hasOne(SipekaJatahAbsensi::class, 'id_pengguna');
    }

}
