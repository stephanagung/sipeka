<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaPlant extends Model
{
    use HasFactory;

    protected $table = 'sipeka_plant';
    protected $primaryKey = 'id_plant';
    public $incrementing = true; // Pastikan ini true untuk auto-increment
    protected $keyType = 'integer'; // Tipe primary key adalah integer

    public $timestamps = false;

    protected $fillable = ['nama_plant', 'kode_plant'];

    public function pengguna()
    {
        return $this->hasMany(SipekaPengguna::class, 'id_plant');
    }

    public function rekapAsesmenPrd()
    {
        return $this->hasMany(SipekaRekapAsesmenPrd::class, 'id_plant');
    }

}
