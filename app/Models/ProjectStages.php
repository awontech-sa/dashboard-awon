<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStages extends Model
{
    use HasFactory;

    protected $table = 'project_stage';

    protected $fillable = [
        'project_id',
        'stage_id'
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stages::class);
    }
}

