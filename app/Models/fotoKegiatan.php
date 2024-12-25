<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fotoKegiatan extends Model
{
    use HasFactory;
    protected $table = "foto_kegiatan";
    protected $primaryKey="kd_fotokeg";
    protected $fillable = ['kd_fotokeg', 'kd_kegiatan', 'foto_path'];
    public $timestamps = false;
    protected $keyType = 'string';

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kd_kegiatan', 'kd_kegiatan');
    }
}
