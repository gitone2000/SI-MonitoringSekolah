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
    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }
    public function jurnalsIzin()
    {
        return $this->belongsToMany(Jurnal::class, 'jurnal_siswa', 'siswa_izin_id', 'jurnal_id');
    }

    // Relasi many-to-many untuk sakit
    public function jurnalsSakit()
    {
        return $this->belongsToMany(Jurnal::class, 'jurnal_siswa', 'siswa_sakit_id', 'jurnal_id');
    }

    // Relasi many-to-many untuk alpha
    public function jurnalsAlpha()
    {
        return $this->belongsToMany(Jurnal::class, 'jurnal_siswa', 'siswa_alpha_id', 'jurnal_id');
    }
}
