<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPhases extends Model
{
    use HasFactory;

    protected $table = 'project_phases';

    protected $fillable = ['project_id', 'phase_cost', 'disbursement_proof', 'disbursement_status'];

    public function projects()
    {
        return $this->belongsTo(Projects::class);
    }
}
