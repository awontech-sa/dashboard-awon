<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowersUserSections extends Model
{
    use HasFactory;

    protected $table = 'powers_user_sections';

    protected $fillable = [
        'user_id',
        'powers_id',
        'powers_sections_id'
    ];
}
