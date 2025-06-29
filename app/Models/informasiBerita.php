<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informasiBerita extends Model
{
    use HasFactory;

    protected $table = 'informasi';
    protected $primaryKey = 'kd_info';
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'judul_berita',
        'isi_berita',
        'status_info',
        'kategori_berita',
        'foto_berita',
        'video_link',
        'author',
        'tanggal_dibuat',
        'kd_kecamatan'
        
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kd_kecamatan', 'kd_kecamatan');
    }
}
