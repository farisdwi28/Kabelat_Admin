<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    use HasFactory;

    protected $table = 'diskusi';
    protected $primaryKey = 'kd_diskusi';
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kd_diskusi',
        'topik_diskusi',
        'isi_diskusi',
        'tglpost_diskusi',
        'kd_komunitas',
        'id'
    ];

    public function komunitas()
    {
        return $this->belongsTo(Komunitas::class, 'kd_komunitas', 'kd_komunitas');
    }

    public function scopeHariIni($query)
    {
        return $query->whereDate('tglpost_diskusi', now()->toDateString());
    }
}
