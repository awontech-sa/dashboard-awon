<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $table = 'projects';

    // public function members()
    // {
    //     return $this->belongsToMany(Members::class, 'team_project')
    //         ->withPivot('roles_id');
    // }

    // public function roles()
    // {
    //     return $this->hasMany(Roles::class);
    // }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'projects_user', 'user_id', 'projects_id');
    // }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user_power')
            ->withPivot('powers_id')->withTimestamps();
    }

    public function userPermissions()
    {
        return $this->belongsToMany(User::class, 'project_user_power')
            ->withPivot('powers_id')->using(ProjectUserPower::class);
    }
}
