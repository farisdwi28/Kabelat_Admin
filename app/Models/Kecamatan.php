<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table="kecamatan";
    protected $primaryKey="kd_kecamatan";
    public $timestamps = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'kd_kecamatan',
        'nm_kecamatan',
    ];
}
