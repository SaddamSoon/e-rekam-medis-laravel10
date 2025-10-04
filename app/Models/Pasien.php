<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $table = 'pasien';
    protected $guarded = ['id'];


    public function user(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
