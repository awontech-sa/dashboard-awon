<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeBenef extends Model
{
    use HasFactory;

    protected $table = 'type_benef';

    protected $fillable = ['tb_name'];

    public function project()
    {
        return $this->morphTo(Projects::class, 'type_benef_id', 'id');
    }
}
