<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Siswa
 *
 * @property int $id
 * @property string $nama_siswa
 */

class Siswa extends Model
{
    use HasFactory;
    protected $table = "siswa";

    public $timestamps = false;
    protected $fillable = [
        'nama_siswa'
    ];
    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }
}
// public function izin()
    // {
    //     return $this->belongsToMany(JurnalChild::class, 'jurnal_siswa', 'siswa_izin_id', 'jurnalchild_id');
    // }

    // // Relasi many-to-many untuk sakit
    // public function sakit()
    // {
    //     return $this->belongsToMany(JurnalChild::class, 'jurnal_siswa', 'siswa_sakit_id', 'jurnalchild_id');
    // }

    // // Relasi many-to-many untuk alpha
    // public function alpha()
    // {
    //     return $this->belongsToMany(JurnalChild::class, 'jurnal_siswa', 'siswa_alpha_id', 'jurnalchild_id');
    // }
