<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class janjiTemu extends Model
{
    use HasFactory;
    protected $table = 'janji_temu';
    protected $guarded = ['id'];
    protected $with = ['dokter'];

    public function dokter(){
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id');
    }
}
