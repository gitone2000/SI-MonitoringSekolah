<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = "kelas";

    public $timestamps = false;

    public function jurnal()
    {
        return $this->hasMany(Jurnal::class,'kelas_id');
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class,'jurusan_id');
    }
}
