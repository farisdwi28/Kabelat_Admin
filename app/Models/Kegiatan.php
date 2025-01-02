<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;
    protected $table="kegiatan";
    protected $primaryKey="kd_kegiatan";
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kd_kegiatan',
        'nm_keg',
        'desk_keg',
        'tgl_mulai',
        'tgl_berakhir',
        'link_keg',
        'lokasi_keg',
        'kd_program',
        'kd_komunitas',
        'kd_katkeg',
        'kecamatan',
        'kelurahan',
        'status'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'kd_program', 'kd_program');
    }

    public function kategori()
    {
        return $this->belongsTo(kategoriKegiatan::class, 'kd_katkeg', 'kd_katkeg');
    }

    public function fotoKegiatan()
    {
        return $this->hasMany(fotoKegiatan::class, 'kd_kegiatan', 'kd_kegiatan');
    }
}


