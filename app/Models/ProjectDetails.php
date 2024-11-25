<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDetails extends Model
{
    use HasFactory;

    protected $table = 'project_details';

    protected $fillable = [
        'projects_id',
        'program_language',
        'framework',
        'github',
        'link',
        'ios',
        'android',
        'dashboard'
    ];

    public function projects()
    {
        return $this->belongsTo(Projects::class);
    }
}
