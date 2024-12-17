<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;
    protected $table = "program";
    protected $primaryKey = "kd_program";
    public $timestamps = false;
    protected $keyType = 'string';

    public function inisiator(): BelongsTo
    {
        return $this->belongsTo(Inisiator::class, 'kd_program', 'kd_program');
    }
}
