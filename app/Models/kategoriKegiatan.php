<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoriKegiatan extends Model
{
    use HasFactory;
    protected $table="kategori_kegiatan";
    protected $primaryKey="kd_katkeg";
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kd_katkeg',
        'nm_katkeg',
        'ket_kat'
    ];
}
