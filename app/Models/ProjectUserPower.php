<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUserPower extends Model
{
    use HasFactory;

    protected $table = 'project_user_power';

    protected $fillable = [
        'user_id',
        'project_id',
        'powers_id',
    ];
}
