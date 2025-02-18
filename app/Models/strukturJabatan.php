<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class strukturJabatan extends Model
{
    use HasFactory;

    protected $table = 'struktur_jabatan';
    protected $primaryKey = 'kd_jabatan';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'kd_jabatan',
        'nm_jabatan',
    ];

    public function members()
    {
        return $this->hasMany(MemberKomunitas::class, 'kd_jabatan', 'kd_jabatan');
    }
}
