<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    use HasFactory;
    protected $table = 'resep_obat';
    protected $guarded = ['id'];
    // protected $with = ['rekmed','obat'];

    public function rekmed()
    {
        return $this->belongsTo(Rekmed::class, 'id_rekam', 'id');
    }
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat'); // pastikan foreign key benar
    }
}
