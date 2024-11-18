<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSupporters extends Model
{
    use HasFactory;

    protected $table = 'project_supporters';

    protected $fillable = [
        'project_id',
        'supporter_name',
        'support_amount',
        'installments_count',
        'report_files',
        'payment_order_files',
        'p_support_status',
        'p_support_type'
    ];
}
