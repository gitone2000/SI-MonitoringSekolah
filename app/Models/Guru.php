<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = "guru";
    public $timestamps = false;
    protected $casts = [
        'mapel' => 'array',
        'tugas' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(Administrator::class,'user_id');
    }

    public function getMapelNamesAttribute()
    {
        if (is_array($this->mapel)) {
            $mapel_names = Mapel::whereIn('id', $this->mapel)->pluck('nama_mapel')->toArray();
            return implode(', ', $mapel_names);
        }
        return '';
    }

    public function getTugasNamesAttribute()
    {
        if (is_array($this->tugas)) {
            $tugas_names = Tugas::whereIn('id', $this->tugas)->pluck('nama_tugas')->toArray();
            return implode(', ', $tugas_names);
        }
        return '';
    }
}
