<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inisiator extends Model
{
    use HasFactory;

    protected $table = 'inisiator';
    protected $primaryKey = 'kd_inisiator';
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kd_inisiator',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'kd_program', 'kd_program');
    }
}
