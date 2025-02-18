<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberKomunitas extends Model
{
    use HasFactory;
    protected $table = "member_komunitas";
    protected $primaryKey = "kd_member";
    public $timestamps = false;
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function komunitas()
    {
        return $this->belongsTo(Komunitas::class, 'kd_komunitas', 'kd_komunitas');
    }

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'kd_pen', 'kd_pen');
    }

    public function jabatan()
    {
        return $this->belongsTo(StrukturJabatan::class, 'kd_jabatan', 'kd_jabatan');
    }
}
