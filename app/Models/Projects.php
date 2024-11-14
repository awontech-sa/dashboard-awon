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
        'p_status',
        'p_num_beneficiaries',
        'p_date_start',
        'p_date_end',
        'p_remaining',
        'p_description',
        'p_files',
        'p_comment',
        'p_level',
        'p_web',
        'p_ios',
        'p_android',
        'p_support_entity',
        'p_stages',
        'p_implemented_stages',
        'type_benef_id'
    ];

    protected $casts = [
        'support_status' => SupportStatus::class,
    ];

    public function typeBenef()
    {
        return $this->morphOne(TypeBenef::class, 'type_benef_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(ProjectFiles::class);
    }

    public function stages()
    {
        return $this->belongsToMany(Stages::class);
    }

    public function projectStages()
    {
        return $this->hasMany(ProjectStages::class);
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
}
