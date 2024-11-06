<?php

namespace Database\Seeders;

use App\Models\PowersSections;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PowersSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PowersSections::create(['ps_name' => 'الحسابات']);
        PowersSections::create(['ps_name' => 'التحصيل']);
        PowersSections::create(['ps_name' => 'الإدارة التقنية']);
        PowersSections::create(['ps_name' => 'الإدارات']);
        PowersSections::create(['ps_name' => 'الشؤون المالية']);
        PowersSections::create(['ps_name' => 'إدارة تنمية الموارد']);
        // PowersSections::create(['ps_name' => 'مشاريع الإدارة التقنية']);
        // PowersSections::create(['ps_name' => 'مشاريع إدارة تنمية الموارد']);
    }
}
