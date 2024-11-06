<?php

namespace Database\Seeders;

use App\Models\Powers;
use Illuminate\Database\Seeder;

class PowersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Powers::create(['p_name' => 'مشاهدة']);
        Powers::create(['p_name' => 'تعديل']);
        Powers::create(['p_name' => 'حذف']);
    }
}
