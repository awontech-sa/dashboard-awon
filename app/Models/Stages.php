<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stages extends Model
{
    use HasFactory;

    protected $fillable = ['stage_name', 'stage_number'];

    public function projects()
    {
        return $this->belongsToMany(Projects::class);
    }

    public function projectStages()
    {
        return $this->hasMany(ProjectStage::class);
    }
}
