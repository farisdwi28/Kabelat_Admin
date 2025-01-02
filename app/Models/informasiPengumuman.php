<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informasiPengumuman extends Model
{
    use HasFactory;

    protected $table = 'informasi_pengumuman';
    protected $primaryKey = 'kd_info';
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'judul_berita',
        'isi_berita',
        'status_info',
        'foto_berita',
        'author',
        'tanggal_dibuat',
        'kd_kecamatan'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kd_kecamatan', 'kd_kecamatan');
    }
}
