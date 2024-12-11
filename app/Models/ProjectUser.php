<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    use HasFactory;

    protected $table = 'projects_user';

    protected $fillable = ['projects_id', 'user_id', 'role'];

    public function projects()
    {
        return $this->belongsTo(Projects::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
