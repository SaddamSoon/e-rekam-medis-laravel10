<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rekmed extends Model
{
    use HasFactory;
    protected $table = 'rekam_medis';
    protected $guarded = ['id'];
    protected $with = ['pasien', 'resep', 'dokter','poly'];

    public function pasien(){
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }
    public function resep(){
        return $this->hasMany(ResepObat::class,'id_rekam', 'id');
    }
    public function dokter(){
        return $this->hasOne(Dokter::class, 'id', 'id_dokter');
    }
    public function poly(){
        return $this->belongsTo(Poly::class, 'id_poly', 'id');
    }
}
