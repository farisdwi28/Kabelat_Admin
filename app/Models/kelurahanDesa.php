<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kelurahanDesa extends Model
{
    use HasFactory;
    protected $table="kelurahan_desa";
    protected $primaryKey="kd_kelurahan";
    public $timestamps = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'kd_kelurahan',
        'nama',
        'kd_kecamatan'
    ];
}
