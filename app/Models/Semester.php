<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $table = "semester";

    public $timestamps = false;

    public function jurnal()
    {
        return $this->hasMany(Jurnal::class);
    }
}
