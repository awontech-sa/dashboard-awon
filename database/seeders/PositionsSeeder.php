<?php

namespace Database\Seeders;

use App\Models\Positions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Positions::create(['p_name' => 'عضو مجلس الإدارة', 'department_id'=> 1]);
        Positions::create(['p_name' => 'رئيس مجلس الإدارة', 'department_id'=> 1]);
        Positions::create(['p_name' => 'مهندس برمجيات', 'department_id'=> 2]);
    }
}
