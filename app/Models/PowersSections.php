<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowersSections extends Model
{
    use HasFactory;

    public function users() {
        return $this->belongsToMany(User::class, 'powers_user_sections')->withPivot('permission');// إضافة permission_id كجزء من العلاقة
    }
}
