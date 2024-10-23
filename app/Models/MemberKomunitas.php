<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberKomunitas extends Model
{
    use HasFactory;
    protected $table="member_komunitas";
    protected $primaryKey="kd_member";
}
