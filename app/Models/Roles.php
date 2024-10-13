<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';

    public function members()
    {
        return $this->belongsToMany(Members::class, 'team_project')
            ->withPivot('projects_id');
    }

    public function projects()
    {
        return $this->hasMany(Projects::class);
    }
}
