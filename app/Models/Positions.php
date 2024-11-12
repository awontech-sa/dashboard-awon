<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = ['p_name', 'department_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'position_user', 'users_id', 'positions_id')->using(PositionUser::class);
    }

    public function department()
    {
        return $this->belongsTo(Departments::class);
    }
}
