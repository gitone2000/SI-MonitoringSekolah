<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class Jurnal
 *
 * @property \Illuminate\Database\Eloquent\Collection $izin
 * @property \Illuminate\Database\Eloquent\Collection $sakit
 * @property \Illuminate\Database\Eloquent\Collection $alpha
 */

class Jurnal extends Model
{
    use HasFactory;
    protected $table = "jurnal";
    public $timestamps = true;

    protected $fillable = [
        'guru_id', 'kelas_id', 'jam_id', 'hari', 'mapel_id', 'tanggal', 'materi'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class,'guru_id');
    }
    public function mapel()
    {
        return $this->belongsTo(Mapel::class,'mapel_id');
    }
    public function jam()
    {
        return $this->belongsTo(Jam::class,'jam_id');
    }
    public function childs()
    {
        return $this->hasMany(JurnalChild::class, 'jurnal_id');
    }
    public function admin()
    {
        return $this->belongsTo(Administrator::class,'user_id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class,'semester_id');
    }

    // public function izin()
    // {
    //     return $this->belongsToMany(Siswa::class,'jurnal_siswa', 'jurnal_id', 'siswa_izin_id');
    // }
    // public function sakit()
    // {
    //     return $this->belongsToMany(Siswa::class,'jurnal_siswa', 'jurnal_id', 'siswa_sakit_id');
    // }
    // public function alpha()
    // {
    //     return $this->belongsToMany(Siswa::class,'jurnal_siswa', 'jurnal_id', 'siswa_alpha_id');
    // }
    // public function jurnalsiswa()
    // {
    //     return $this->belongsTo(JurnalSiswa::class);
    // }
    // public function childs()
    // {
    //     return $this->hasMany(Jurnal::class,'guru_id','id');
    // }

}

