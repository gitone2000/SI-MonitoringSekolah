<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $table = "mapel";

    public $timestamps = false;
    public function muatan()
    {
        return $this->belongsTo(Muatan::class,'muatan_id');
    }
}
