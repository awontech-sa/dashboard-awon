<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProjectsModel extends Model
{
    use HasFactory;

    protected $table = 'users_projects';

    public function projects()
    {
        return $this->hasMany(Projects::class);
    }
}
