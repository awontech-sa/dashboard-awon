<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PositionUser extends Pivot
{
    use HasFactory;

    protected $table = 'position_user';
}
