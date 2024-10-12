<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamProject extends Model
{
    use HasFactory;

    protected $table = 'team_project';

    public function projects()
    {
        return $this->belongsTo(Projects::class);
    }

    public function members()
    {
        return $this->belongsTo(Members::class);
    }

    public function roles()
    {
        return $this->belongsTo(Roles::class);
    }
}
