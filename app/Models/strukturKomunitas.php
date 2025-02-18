<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class strukturKomunitas extends Model
{
    use HasFactory;

    protected $table = 'struktur_jabatan';
    protected $primaryKey = 'kd_jabatan';
    public $incrementing = false;
    protected $keyType = 'string';

    public function komunitas()
    {
        return $this->belongsToMany(Komunitas::class, 'komunitas_jabatan', 'kd_jabatan', 'kd_komunitas');
    }
}
