<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Auth\Database\Administrator;

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

    // protected $casts = [
    //     'siswa_id' => 'json',
    // ];

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
    public function izin()
    {
        return $this->belongsToMany(Siswa::class,'jurnal_siswa', 'jurnal_id', 'siswa_izin_id');
    }
    public function sakit()
    {
        return $this->belongsToMany(Siswa::class,'jurnal_siswa', 'jurnal_id', 'siswa_sakit_id');
    }
    public function alpha()
    {
        return $this->belongsToMany(Siswa::class,'jurnal_siswa', 'jurnal_id', 'siswa_alpha_id');
    }

    public function jurnalsiswa()
    {
        return $this->belongsTo(JurnalSiswa::class);
    }
    public function admin()
    {
        return $this->belongsTo(Administrator::class,'user_id');
    }

    // public function getTagsAttribute($value)
    // {
    //     return explode(',', $value);
    // }
    // public function setTagsAttribute($value)
    // {
    //     $this->attributes['absen'] = implode(',', $value);
    // }

}
