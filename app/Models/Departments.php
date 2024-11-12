<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;

    protected $table = 'departments';
    protected $fillable = ['d_name'];

    public function positions()
    {
        return $this->hasMany(Positions::class);
    }
}
