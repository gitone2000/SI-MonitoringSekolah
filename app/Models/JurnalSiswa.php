<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalSiswa extends Model
{
    use HasFactory;
    protected $table = "jurnal_siswa";
    public $timestamps = true;
    protected $fillable = [
        'jurnalchild_id', 'siswa_izin_id', 'siswa_sakit_id', 'siswa_alpha_id'
    ];

}
