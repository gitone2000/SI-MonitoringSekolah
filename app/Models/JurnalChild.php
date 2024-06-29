<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalChild extends Model
{
    use HasFactory;
    protected $table = "jurnalchild";

    protected $casts = [
        'izin' => 'array',
        'sakit' => 'array',
        'alpha' => 'array',
    ];

    protected $fillable = [
        'jurnal_id','tanggal', 'materi', 'izin', 'sakit', 'alpha'
    ];
    public $timestamps = false;

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class, 'jurnal_id');
    }
    // public function getIzinAttribute($value)
    // {
    //     return $this->convertSiswaNames($value);
    // }

    // public function getSakitAttribute($value)
    // {
    //     return $this->convertSiswaNames($value);
    // }

    // public function getAlphaAttribute($value)
    // {
    //     return $this->convertSiswaNames($value);
    // }

    // private function convertSiswaNames($ids)
    // {
    //     if (is_array($ids)) {
    //         $names = Siswa::whereIn('id', $ids)->pluck('nama_siswa')->toArray();
    //         return implode(', ', $names);
    //     }
    //     return $ids;
    // }
}
    // public function izin()
    // {
    //     return $this->belongsToMany(Siswa::class, 'jurnal_siswa', 'jurnalchild_id', 'siswa_izin_id');
    // }
    // public function sakit()
    // {
    //     return $this->belongsToMany(Siswa::class, 'jurnal_siswa', 'jurnalchild_id', 'siswa_sakit_id');
    // }
    // public function alpha()
    // {
    //     return $this->belongsToMany(Siswa::class, 'jurnal_siswa', 'jurnalchild_id', 'siswa_alpha_id');
    // }
