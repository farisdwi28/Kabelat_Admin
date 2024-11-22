<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komunitas extends Model
{
    use HasFactory;
    protected $table="komunitas";
    protected $primaryKey="kd_komunitas";
    public $timestamps = false;
    protected $keyType = 'string';

    public function Ketua(): HasOne
    {
        return $this->hasOne(MemberKomunitas::class, 'kd_komunitas')->where('kd_jabatan','KETUA');
    }

    public function Members(): HasMany
    {
        return $this->hasMany(MemberKomunitas::class, 'kd_komunitas', 'kd_komunitas');
    }
}