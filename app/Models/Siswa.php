<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = "siswa";

    public $timestamps = false;
    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }
    public function jurnal()
    {
        return $this->belongsToMany(Jurnal::class,'jurnal_siswa', 'siswa_id', 'jurnal_id');
    }
    
}
