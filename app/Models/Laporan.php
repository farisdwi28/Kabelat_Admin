<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'kd_laporan';


    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kd_laporan',
        'judul',
        'tgl_dibuat',
        'desk_lap',
        'status_periksa',
        'file',
        'kd_member',
    ];
    protected $dates = ['tgl_dibuat'];
    public function user()
    {
        return $this->belongsTo(User::class, 'kd_member');
    }
    public function komunitas()
    {
        return $this->belongsTo(Komunitas::class, 'kd_komunitas', 'kd_komunitas');
    }
}
