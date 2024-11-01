<?php

namespace Database\Seeders;

use App\Models\Departments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departments::create(['d_name' => 'مجلس الإدارة']);
        Departments::create(['d_name' => 'الإدارة التقنية']);
    }
}
