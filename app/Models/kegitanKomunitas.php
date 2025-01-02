<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kegitanKomunitas extends Model
{
    use HasFactory;
    protected $table="kegiatan_komunitas";
    protected $primaryKey="kd_kegiatan2";
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kd_kegiatan2',
        'nm_keg',
        'desk_keg',
        'tgl_mulai',
        'tgl_berakhir',
        'link_keg',
        'lokasi_keg',
        'kd_komunitas',
        'kd_katkeg',
        'kecamatan',
        'kelurahan',
        'status'
    ];

    public function komunitas()
    {
        return $this->belongsTo(Komunitas::class, 'kd_komunitas', 'kd_komunitas');
    }

    public function kategori()
    {
        return $this->belongsTo(kategoriKegiatan::class, 'kd_katkeg', 'kd_katkeg');
    }

    public function fotoKegiatan()
    {
        return $this->hasMany(fotoKegiatan::class, 'kd_kegiatan2', 'kd_kegiatan2');
    }
}
