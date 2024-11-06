<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_verified'
    ];

    protected $guard_name = 'web';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function projects()
    {
        return $this->belongsToMany(Projects::class, 'projects_user', 'user_id', 'projects_id');
    }

    public function projectss()
    {
        return $this->belongsToMany(Projects::class, 'project_user_power')
            ->withPivot('powers_id')->withTimestamps();
    }

    public function projectPowers()
    {
        return $this->belongsToMany(Projects::class, 'project_user_power')->withPivot('powers_id')
            ->using(ProjectUserPower::class);
    }



    public function getProfileImageAttribute()
    {
        return config('filesystems.disks.digitalocean.url') . '/' . $this->attributes['profile_image'];
    }

    public function positions()
    {
        return $this->belongsToMany(Positions::class, 'position_user', 'users_id', 'positions_id')->using(PositionUser::class);
    }

    public function powers()
    {
        return $this->belongsToMany(Powers::class, 'powers_user_sections')->withPivot('powers_sections_id'); // إضافة department_id كجزء من العلاقة
    }

    public function powersSections()
    {
        return $this->belongsToMany(PowersSections::class, 'powers_user_sections')->withPivot('powers_id'); // إضافة permission_id كجزء من العلاقة
    }
}
