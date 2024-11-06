<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowersSections extends Model
{
    use HasFactory;

    public function users() {
        return $this->belongsToMany(User::class, 'powers_user_sections')
                    ->withPivot('powers_id'); // إضافة permission_id كجزء من العلاقة
    }

    public function powers() {
        return $this->belongsToMany(Powers::class, 'powers_user_sections')
                    ->withPivot('user_id'); // إضافة user_id كجزء من العلاقة
    }
}
