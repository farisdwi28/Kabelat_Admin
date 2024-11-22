<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;
    protected $table="penduduk";
    protected $primaryKey="kd_pen";
    public $timestamps = false;
    
}
