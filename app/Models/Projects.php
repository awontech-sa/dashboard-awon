<?php

namespace App\Models;

use App\Enums\SupportStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'p_name',
        'p_num_beneficiaries',
        'p_date_start',
        'p_date_end',
        'p_remaining',
        'p_description',
        'p_duration',
        'expected_cost',
        'total_cost',
        'comment',
        'type_benef'
    ];

    protected $casts = [
        'support_status' => SupportStatus::class,
    ];

    public function files()
    {
        return $this->hasMany(ProjectFiles::class);
    }

    public function stages()
    {
        return $this->belongsToMany(Stages::class, 'project_stage', 'projects_id', 'stages_id');
    }

    public function stage()
    {
        return $this->hasMany(Stages::class, 'projects_id');
    }

    public function stageOfProject()
    {
        return $this->belongsToMany(Stages::class, 'project_stage');
    }

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

    public function supporter()
    {
        return $this->hasMany(ProjectSupporters::class);
    }

    public function installments()
    {
        return $this->hasMany(Installments::class);
    }

    public function details()
    {
        return $this->hasOne(ProjectDetails::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'projects_user')->withPivot('role');
    }
}
