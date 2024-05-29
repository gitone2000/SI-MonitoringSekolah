<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Auth\Database\Administrator;

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
    public function ijin()
    {
        return $this->belongsToMany(Siswa::class,'jurnal_siswa', 'jurnal_id', 'siswa_id');
    }
    // public function sakit()
    // {
    //     return $this->belongsToMany(Siswa::class,'jurnal_siswa', 'jurnal_id', 'siswa_id');
    // }
    // public function alpha()
    // {
    //     return $this->belongsToMany(Siswa::class,'jurnal_siswa', 'jurnal_id', 'siswa_id');
    // }
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
