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
        'p_support_type',
        'supporter_number'
    ];

    public function projects()
    {
        return $this->belongsTo(Projects::class);
    }

    public function installments()
    {
        return $this->hasMany(Installments::class);
    }

    public function getReportFilesAttribute()
    {
        $baseUrl = config('filesystems.disks.digitalocean.url');
        $reportFiles = json_decode($this->attributes['report_files'], true);
        if (is_array($reportFiles)) {
            $formattedReportFiles = array_map(function ($report) use ($baseUrl) {
                return $baseUrl . '/' . $report['report'];
            }, $reportFiles);

            return $formattedReportFiles;
        }

        return [];
    }

    public function getPaymentOrderFilesAttribute()
    {
        $baseUrl = config('filesystems.disks.digitalocean.url');
        $paymentOrderFiles = json_decode($this->attributes['payment_order_files'], true);
        if (is_array($paymentOrderFiles)) {
            $formattedpaymentOrderFiles = array_map(function ($payment) use ($baseUrl) {
                return $baseUrl . '/' . $payment['payment_order'];
            }, $paymentOrderFiles);

            return $formattedpaymentOrderFiles;
        }

        return [];
    }
}
