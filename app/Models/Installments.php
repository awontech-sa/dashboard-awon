<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installments extends Model
{
    use HasFactory;

    protected $table = 'installments';
    protected $fillable = ['project_supporters_id', 'project_id' , 'installment_amount', 'receipt_proof', 'installment_receipt_status'];

    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    public function supporter()
    {
        return $this->belongsTo(ProjectSupporters::class, 'project_supporter_id');
    }

    public function getFileAttribute()
    {
        return config('filesystems.disks.digitalocean.url') . '/' . $this->attributes['receipt_proof'];
    }
}
