<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SipekaDepartemen extends Model
{
    use HasFactory;

    protected $table = 'sipeka_departemen';
    protected $primaryKey = 'id_departemen';
    public $incrementing = true; // Pastikan ini true untuk auto-increment
    protected $keyType = 'integer'; // Tipe primary key adalah integer

    protected $fillable = ['nama_departemen', 'kode_departemen'];

    public function pengguna()
    {
        return $this->hasMany(SipekaPengguna::class, 'id_departemen');
    }
}
