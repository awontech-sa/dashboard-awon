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
            'p_support_entity' => "عون التقنية",
            'p_stages' => 10,
            'p_implemented_stages' => 7
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
            'p_files' => json_encode([['name' => 'PRD dashboard', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/PRD%20Dashboard.pdf']]),
            'p_comment' => null,
            'p_level' => 'البرمجة',
            'p_web' => 'https://dashboard.awontech.sa/',
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "عون التقنية",
            'p_stages' => 10,
            'p_implemented_stages' => 10
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
                ['name' => ' Sakhi SRS', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/Sakhaa%20SRS%20.pdf'],
                ['name' => 'الفيديو الاستثماري', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D8%A7%D9%84%D9%81%D9%8A%D8%AF%D9%8A%D9%88%20%D8%A7%D9%84%D8%A7%D8%B3%D8%AA%D8%AB%D9%85%D8%A7%D8%B1%D9%8A.mp4'],
                ['name' => 'فيديو سخي', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D9%81%D9%8A%D8%AF%D9%8A%D9%88%20%D8%B3%D8%AE%D9%8A.mp4'],
                ['name' => 'ملف سخي الاستثماري', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D9%85%D9%84%D9%81%20%D8%B3%D8%AE%D9%8A%20%D8%A7%D9%84%D8%A7%D8%B3%D8%AA%D8%AB%D9%85%D8%A7%D8%B1%D9%8A.pdf'],
                ['name' => 'ملف منصة سخي', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D9%85%D9%84%D9%81%20%D9%85%D9%86%D8%B5%D8%A9%20%D8%B3%D8%AE%D9%8A.pdf'],
                ['name' => 'هوية سخي', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D9%87%D9%88%D9%8A%D8%A9%20%D8%B3%D8%AE%D9%8A.pdf'],
            ]),
            'p_comment' => null,
            'p_level' => 'البرمجة',
            'p_web' => null,
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "عون التقنية",
            'p_stages' => 10,
            'p_implemented_stages' => 3
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
            'p_files' => json_encode([
                ['name' => 'مواصفات متطلبات النظام', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/__%D9%85%D9%88%D8%A7%D8%B5%D9%81%D8%A7%D8%AA%20%D9%85%D8%AA%D8%B7%D9%84%D8%A8%D8%A7%D8%AA%20%D8%A7%D9%84%D9%86%D8%B8%D8%A7%D9%85%20-%20%D9%81%D8%B1%D8%B5%D8%A9_.pdf'],
                ['name' => 'اتفاقية تنفيذ نظام فرصة', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D8%A7%D8%AA%D9%81%D8%A7%D9%82%D9%8A%D8%A9%20%D8%AA%D9%86%D9%81%D9%8A%D8%B0%20%D9%86%D8%B8%D8%A7%D9%85%20%D9%81%D8%B1%D8%B5%D8%A9.pdf'],
                ['name' => 'فرصة', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D9%81%D8%B1%D8%B5%D8%A9.pdf'],
                ['name' => 'منصة فرصة الاصدار 1.1', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D9%85%D9%86%D8%B5%D8%A9%20%D9%81%D8%B1%D8%B5%D8%A9%20%D8%A7%D9%84%D8%A7%D8%B5%D8%AF%D8%A7%D8%B1%201.1.pdf'],
                ['name' => 'منصة فرصة الاصدار 1.2', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D9%85%D9%86%D8%B5%D8%A9%20%D9%81%D8%B1%D8%B5%D8%A9%20%D8%A7%D9%84%D8%A7%D8%B5%D8%AF%D8%A7%D8%B1%201.2.pdf'],
                ['name' => 'نظام فرصة - المرحلة الثالثة', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D9%86%D8%B8%D8%A7%D9%85%20%D9%81%D8%B1%D8%B5%D8%A9%20-%20%D8%A7%D9%84%D9%85%D8%B1%D8%AD%D9%84%D8%A9%20%D8%A7%D9%84%D8%AB%D8%A7%D9%84%D8%AB%D8%A9.pdf'],
            ]),
            'p_comment' => 'منتهي غالباً، ولكن يوجد جزء متوقف على 
بيانات من طرفهم، وللآن لم يتم تزويدنا بها',
            'p_level' => 'البرمجة',
            'p_web' => 'https://forsa-stg.awontech.sa',
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "جهة خارجة",
            'p_stages' => 10,
            'p_implemented_stages' => 3
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
            'p_files' => json_encode([
                ['name' => 'ملحق اتفاقية تنفيذ تطبيق وعي', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/__%D9%85%D9%84%D8%AD%D9%82%20%D8%A7%D8%AA%D9%81%D8%A7%D9%82%D9%8A%D8%A9%20%D8%AA%D9%86%D9%81%D9%8A%D8%B0%20%D8%AA%D8%B7%D8%A8%D9%8A%D9%82%20%D9%88%D8%B9%D9%8A%20%201-1_%20(1).pdf'],
                ['name' => 'SRS وعي', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D9%88%D8%B9%D9%8A%20SRS.pdf'],
            ]),
            'p_comment' => null,
            'p_level' => 'البرمجة',
            'p_web' => 'https://forsa-stg.awontech.sa',
            'p_ios' => 'https://apps.apple.com/us/app/%D8%AA%D8%B7%D8%A8%D9%8A%D9%82-%D9%88%D8%B9%D9%8A/id6473122987',
            'p_android' => null,
            'p_support_entity' => "جهة خارجة",
            'p_stages' => 10,
            'p_implemented_stages' => 7
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
            'p_files' => json_encode([
                ['name' => 'اتفاقية منصات مركز الهدى', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D8%A7%D8%AA%D9%81%D8%A7%D9%82%D9%8A%D8%A9%20%D9%85%D9%86%D8%B5%D8%A7%D8%AA%20%D9%85%D8%B1%D9%83%D8%B2%20%D8%A7%D9%84%D9%87%D8%AF%D9%89.pdf'],
                ['name' => 'التقرير الختامي لمشروع منصات مركز مكة العالمي للهدايات القرآنية', 'value' => 'https://dashboard-awon.nyc3.digitaloceanspaces.com/project-files/%D8%A7%D9%84%D8%AA%D9%82%D8%B1%D9%8A%D8%B1%20%D8%A7%D9%84%D8%AE%D8%AA%D8%A7%D9%85%D9%8A%20%D9%84%D9%85%D8%B4%D8%B1%D9%88%D8%B9%20%D9%85%D9%86%D8%B5%D8%A7%D8%AA%20%D9%85%D8%B1%D9%83%D8%B2%20%D9%85%D9%83%D8%A9%20%D8%A7%D9%84%D8%B9%D8%A7%D9%84%D9%85%D9%8A%20%D9%84%D9%84%D9%87%D8%AF%D8%A7%D9%8A%D8%A7%D8%AA%20%D8%A7%D9%84%D9%82%D8%B1%D8%A7%D9%93%D9%86%D9%8A%D8%A9.pdf'],
            ]),
            'p_comment' => null,
            'p_level' => null,
            'p_web' => 'https://hidayaa.org',
            'p_ios' => null,
            'p_android' => null,
            'p_support_entity' => "جهة خارجة",
            'p_stages' => 10,
            'p_implemented_stages' => 10
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
            'p_android' => 'https://play.google.com/store/apps/details?id=sa.awonteck.digital&pcampaignid=web_share',
            'p_stages' => 10,
            'p_implemented_stages' => 3
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
            'p_support_entity' => "عون التقنية",
            'p_stages' => 10,
            'p_implemented_stages' => 3
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
            'p_support_entity' => "جهة خارجة",
            'p_stages' => 10,
            'p_implemented_stages' => 7
        ]);
    }
}
