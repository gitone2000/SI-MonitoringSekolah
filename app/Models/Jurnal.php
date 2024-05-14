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

    public function kelas()
    {
        return $this->belongsTo(Kelas::class,'kelas_id');
    }
    public function mapel()
    {
        return $this->belongsTo(Mapel::class,'mapel_id');
    }
    public function jam()
    {
        return $this->belongsTo(Jam::class,'jam_id');
    }
    public function siswa()
    {
        return $this->belongsTo(Siswa::class,'siswa_id');
    }
    public function keterangan()
    {
        return $this->belongsTo(Keterangan::class,'keterangan_id');
    }

    public function admin()
    {
        return $this->belongsTo(Administrator::class,'user_id');
    }

}
