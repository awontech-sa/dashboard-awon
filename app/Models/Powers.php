<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Powers extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'powers_user_sections')
            ->withPivot('powers_sections_id'); // إضافة department_id كجزء من العلاقة
    }

    public function powersSections()
    {
        return $this->belongsToMany(PowersSections::class, 'powers_user_sections')
            ->withPivot('user_id'); // إضافة user_id كجزء من العلاقة
    }
}
