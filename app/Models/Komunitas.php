<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komunitas extends Model
{
    use HasFactory;
    protected $table = "komunitas";
    protected $primaryKey = "kd_komunitas";
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kd_komunitas',
        'nm_komunitas',
        'logo',
        'status',
        'tanggal_dibuat'
    ];

    public function Ketua(): HasOne
    {
        return $this->hasOne(MemberKomunitas::class, 'kd_komunitas')
            ->join('users', 'member_komunitas.id', '=', 'users.id')
            ->join('penduduk', 'users.kd_pen', '=', 'penduduk.kd_pen')
            ->where('kd_jabatan', 'KETUA')
            ->select(
                'member_komunitas.*',
                'penduduk.nm_pen as nm_member'
            );
    }

    public function Ketua2(): HasOne
    {
        return $this->hasOne(MemberKomunitas::class, 'kd_komunitas')
            ->join('users', 'member_komunitas.id', '=', 'users.id')
            ->join('penduduk', 'users.kd_pen', '=', 'penduduk.kd_pen')
            ->where('kd_jabatan', 'KET01')
            ->select(
                'member_komunitas.*',
                'penduduk.nm_pen as nm_member'
            );
    }

    public function Members(): HasMany
    {
        return $this->hasMany(MemberKomunitas::class, 'kd_komunitas', 'kd_komunitas')
            ->join('users', 'member_komunitas.id', '=', 'users.id')
            ->join('penduduk', 'users.kd_pen', '=', 'penduduk.kd_pen')
            ->select(
                'member_komunitas.*',
                'penduduk.nm_pen as nm_member',
                'penduduk.kecamatan',
                'penduduk.RT',
                'penduduk.RW',
            );
    }

    public function diskusi()
    {
        return $this->hasMany(Diskusi::class, 'kd_komunitas', 'kd_komunitas');
    }

    public function getDiskusiHariIniCount()
    {
        return $this->diskusi()
            ->whereDate('tglpost_diskusi', now()->toDateString())
            ->count();
    }

    public function kegiatanKomunitas()
    {
        return $this->hasMany(kegitanKomunitas::class, 'kd_komunitas', 'kd_komunitas');
    }

    public function jabatan()
    {
        return $this->belongsToMany(StrukturJabatan::class, 'komunitas_jabatan', 'kd_komunitas', 'kd_jabatan');
    }
}
