<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoKegiatan extends Model
{
    use HasFactory;
    protected $table = "foto_kegiatan";
    protected $primaryKey="kd_fotokeg";
    protected $fillable = ['kd_fotokeg', 'kd_kegiatan', 'foto_path', 'kd_kegiatan2'];
    public $timestamps = false;
    protected $keyType = 'string';

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kd_kegiatan', 'kd_kegiatan');
    }

    public function kegiatan2()
    {
        return $this->belongsTo(kegitanKomunitas::class, 'kd_kegiatan2', 'kd_kegiatan2');
    }
}
