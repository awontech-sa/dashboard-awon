<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Projects;

class ProjectsTableSeeder extends Seeder
{
    public function run()
    {
        Projects::query()->create([
            'p_name' => 'موقع عون',
            'p_status' => 'معلق',
            'p_support' => 0,
            'p_type_beneficiaries' => 'جهة',
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
            'p_support_entity' => "عون التقنية"
        ]);

        Projects::query()->create([
            'p_name' => 'لوحة تحكم عون',
            'p_status' => 'قيد التنفيذ',
            'p_support' => 0,
            'p_type_beneficiaries' => 'جهة',
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2024/07/16',
            'p_date_end' => '2024/10/01',
            'p_remaining' => 'منتهي جزئيًا',
            'p_description' => 'نظام متكامل لعرض المشاريع الخاصة بالجمعية',
            'p_files' => json_encode(['value' => 'PRD Dashboard-2.pdf']),
            'p_comment' => null,
            'p_level' => 'البرمجة',
            'p_web' => 'https://dashboard.awontech.sa/',
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "عون التقنية"
        ]);

        Projects::query()->create([
            'p_name' => 'تطبيق سخي',
            'p_status' => 'قيد التنفيذ',
            'p_support' => 0,
            'p_type_beneficiaries' => 'جهة',
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2022-09-01',
            'p_date_end' => null,
            'p_remaining' => null,
            'p_description' => 'تطبيق يربط الجمعيات والمتاجرفي منصة واحدة بهدف إيصال الدعم والاحتياجات الغذائية والطبية لمستفيدي الجمعيات',
            'p_files' => json_encode([
                ['value' => 'فيديو سخي.mp4'],
                ['value' => 'ملف منصة سخي.pdf'],
                ['value' => 'ملف سخي الاستثماري.pdf']
            ]),
            'p_comment' => null,
            'p_level' => 'البرمجة',
            'p_web' => null,
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "عون التقنية"
        ]);

        Projects::query()->create([
            'p_name' => 'نظام فرصة',
            'p_status' => 'قيد التنفيذ',
            'p_support' => 0,
            'p_type_beneficiaries' => 'جهة',
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2023-11-06',
            'p_date_end' => '2024-08-06',
            'p_remaining' => 'تم الانتهاء منه',
            'p_description' => 'منصة الكترونية تصنع الثقة بين المستقلين و طالبي الخدمات المتنوعة ، و تلبي احتياجاتهم بأعلى معايير الجودة',
            'p_files' => json_encode([['value' => 'فرصة.pdf']]),
            'p_comment' => 'منتهي غالباً، ولكن يوجد جزء متوقف على 
بيانات من طرفهم، وللآن لم يتم تزويدنا بها',
            'p_level' => 'البرمجة',
            'p_web' => 'https://forsa-stg.awontech.sa',
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "جهة خارجة"
        ]);

        Projects::query()->create([
            'p_name' => 'تطبيق وعي',
            'p_status' => 'مكتمل',
            'p_support' => 0,
            'p_type_beneficiaries' => 'جهة',
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2023-09-01',
            'p_date_end' => null,
            'p_remaining' => 'تم الانتهاء منه',
            'p_description' => 'منصة الكترونية تصنع الثقة بين المستقلين و طالبي الخدمات المتنوعة ، و تلبي احتياجاتهم بأعلى معايير الجودة',
            'p_files' => json_encode([['value' => 'فرصة.pdf']]),
            'p_comment' => null,
            'p_level' => 'البرمجة',
            'p_web' => 'https://forsa-stg.awontech.sa',
            'p_ios' => 'https://apps.apple.com/us/app/%D8%AA%D8%B7%D8%A8%D9%8A%D9%82-%D9%88%D8%B9%D9%8A/id6473122987',
            'p_android' => null,
            'p_support_entity' => "جهة خارجة"
        ]);

        Projects::query()->create([
            'p_name' => 'إدارة منصات مركز الهدى',
            'p_status' => 'قيد التنفيذ',
            'p_support' => 0,
            'p_type_beneficiaries' => 'جهة',
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2024-01-01',
            'p_date_end' => '2025-01-01',
            'p_remaining' => 'قيد التنفيذ',
            'p_description' => null,
            'p_files' => json_encode(['value' => 'التقرير الختامي لمشروع منصات مركز مكة العالمي للهدايات القرآنية']),
            'p_comment' => null,
            'p_level' => null,
            'p_web' => 'https://hidayaa.org',
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "جهة خارجة"
        ]);

        Projects::query()->create([
            'p_name' => 'الدليل الرقمي',
            'p_status' => 'قيد التنفيذ',
            'p_support' => 1,
            'p_type_beneficiaries' => 'جهة',
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2023-01-01',
            'p_date_end' => null,
            'p_remaining' => 'منتهي جزئيا تبقى حل المشاكل لنظام أبل',
            'p_description' => null,
            'p_files' => null,
            'p_comment' => 'منتهي جزئيا تبقى حل المشاكل لنظام أبل',
            'p_level' => 'البرمجة',
            'p_web' => null,
            'p_ios' => null,
            'p_android' => 'https://play.google.com/store/apps/details?id=sa.awonteck.digital&pcampaignid=web_share'
        ]);

        Projects::query()->create([
            'p_name' => 'تطبيق مكة السياحي',
            'p_status' => 'قيد التنفيذ',
            'p_support' => 0,
            'p_type_beneficiaries' => "فرد",
            'p_num_beneficiaries' => 1,
            'p_date_start' => '2024-09-01',
            'p_date_end' => null,
            'p_remaining' => '١٩ يوم',
            'p_description' => null,
            'p_files' => null,
            'p_comment' => null,
            'p_level' => 'تصميم واجهات المستخدم',
            'p_web' => null,
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "عون التقنية"
        ]);

        Projects::query()->create([
            'p_name' => 'نظام إدارة المحتوى',
            'p_status' => 'قيد التنفيذ',
            'p_support' => 1,
            'p_type_beneficiaries' => 'جهة',
            'p_num_beneficiaries' => 9,
            'p_date_start' => '2023-12-11',
            'p_date_end' => null,
            'p_remaining' => 'قيد التعديل والتطوير حسب متطلبات كل جمعية',
            'p_description' => null,
            'p_files' => null,
            'p_comment' => null,
            'p_level' => 'تصميم واجهات المستخدم',
            'p_web' => null,
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "جهة خارجة"
        ]);
    }
}
