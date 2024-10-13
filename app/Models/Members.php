<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class Members extends Model
{
    use HasFactory;

    protected $table = 'members';

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'team_project')
            ->withPivot('projects_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'team_project')
            ->withPivot('roles_id');
    }
}
