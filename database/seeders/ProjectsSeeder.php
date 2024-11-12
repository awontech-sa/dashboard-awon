<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Projects;

class ProjectsSeeder extends Seeder
{
    public function run()
    {
        Projects::query()->create([
            'p_name' => 'موقع عون',
            'p_status' => 'معلق',
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2022-09-01',
            'p_date_end' => null,
            'p_remaining' => null,
            'p_description' => 'جمعية عون التقنية تهدف إلى تمكين منظمات القطاع الثالث تقنياً من خلال تطوير البرامج التقنية، تقديم الاستشارات، التدريب، والتأهيل في المجال التقني، مع التركيز على تعزيز التوعية والاستخدام الأمثل للتقنية لخدمة المجتمع.',
            'p_files' => null,
            'p_comment' => 'بسبب العمل على المشاريع الاخرى',
            'p_level' => 'البرمجة',
            'p_web' => 'https://awontech.sa/home',
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "عون التقنية",
            'p_stages' => 10,
            'p_implemented_stages' => 7,
            'type_benef_id' => 1
        ]);

        Projects::query()->create([
            'p_name' => 'لوحة تحكم عون',
            'p_status' => 'قيد التنفيذ',
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2024/07/16',
            'p_date_end' => '2024/10/01',
            'p_remaining' => 'منتهي جزئيًا',
            'p_description' => 'نظام متكامل لعرض المشاريع الخاصة بالجمعية',
            'p_files' => json_encode([['name' => 'PRD dashboard', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/PRD%20Dashboard.pdf']]),
            'p_comment' => null,
            'p_level' => 'البرمجة',
            'p_web' => 'https://dashboard.awontech.sa/',
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "عون التقنية",
            'p_stages' => 10,
            'p_implemented_stages' => 10,
            'type_benef_id' => 1
        ]);
    }
}
