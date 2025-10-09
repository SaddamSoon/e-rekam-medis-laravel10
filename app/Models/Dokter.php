<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;
    protected $table = 'dokter';
    protected $guarded = ['id'];
    protected $with = ['ket_dok','user','spesialis','poly'];

    public function user(){
        return $this->hasOne(User::class, 'id_dokter', 'id');
    }
    public function spesialis(){
        return $this->belongsTo(spesialis::class, 'id_spesialis', 'id');
    }
    public function ket_dok(){
        return $this->hasOne(KetDok::class, 'id_dokter', 'id');
    }
    public function poly(){
        return $this->belongsTo(Poly::class, 'id_poly', 'id');
    }
}
