<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananTarif extends Model
{
    use HasFactory;
    protected $table = 'layanan_tarif';
    protected $guarded = ['id'];
    protected $with = ['poly'];

    public function poly(){
        return $this->belongsTo(Poly::class, 'id_poly', 'id');
    }
}
