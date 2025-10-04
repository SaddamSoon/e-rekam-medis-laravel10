<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetDok extends Model
{
    use HasFactory;
    protected $table = 'ketersediaan_dokter';
    protected $guarded = ['id'];



}
