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
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2022-09-01',
            'p_date_end' => null,
            'p_remaining' => null,
            'p_description' => 'جمعية عون التقنية تهدف إلى تمكين منظمات القطاع الثالث تقنياً من خلال تطوير البرامج التقنية، تقديم الاستشارات، التدريب، والتأهيل في المجال التقني، مع التركيز على تعزيز التوعية والاستخدام الأمثل للتقنية لخدمة المجتمع.',
            'type_benef_id' => 1
        ]);

        Projects::query()->create([
            'p_name' => 'لوحة تحكم عون',
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2024/07/16',
            'p_date_end' => '2024/10/01',
            'p_remaining' => 'منتهي جزئيًا',
            'p_description' => 'نظام متكامل لعرض المشاريع الخاصة بالجمعية',
            'type_benef_id' => 1
        ]);
    }
}
