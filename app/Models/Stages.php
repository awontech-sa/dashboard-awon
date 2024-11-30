<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stages extends Model
{
    use HasFactory;

    protected $fillable = ['stage_name', 'stage_number', 'projects_id'];

    public function projects()
    {
        return $this->belongsToMany(Projects::class, 'project_stage', 'projects_id', 'stages_id');
    }

    public function project()
    {
        return $this->belongsTo(Projects::class, 'projects_id');
    }
}
