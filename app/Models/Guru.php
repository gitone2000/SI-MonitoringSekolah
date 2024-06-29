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

    public function admin()
    {
        return $this->belongsTo(Administrator::class,'user_id');
    }

    // public function mapel()
    // {
    //     return $this->belongsTo(Mapel::c'lass,'mapel_id');
    // }
}
