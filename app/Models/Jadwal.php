<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = "jadwal";
    public $timestamps = false;

    public function guru()
    {
        return $this->belongsTo(Guru::class,'guru_id');
    }
    public function jam()
    {
        return $this->belongsTo(Jam::class,'jam_id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }
    public function mapel()
    {
        return $this->belongsTo(Mapel::class,'mapel_id');
    }
}
