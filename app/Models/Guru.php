<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = "guru";
    public $timestamps = false;

    // public function mapel()
    // {
    //     return $this->belongsTo(Mapel::class,'mapel_id');
    // }
}
