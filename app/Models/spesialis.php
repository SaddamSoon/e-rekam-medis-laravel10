<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spesialis extends Model
{
    use HasFactory;
    protected $table = 'spesialis_dokter';
    protected $guarded = ['id'];
    protected $with = ['poly'];

    public function poly(){
        return $this->hasOne(Poly::class, 'id', 'id_poly');
    }
}
