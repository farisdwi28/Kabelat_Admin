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
    protected $keyType = 'string';
    
    protected $fillable = [
        'nm_pen',
        'jk',
        'tgl_lahir',
        'tempat_lahir',
        'alamat',
        'foto_pen'
    ];
}
