<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ayman = User::create([
            'name' => 'أيمن الحربي',
            'email' => 'ayman@awontech.sa',
            'password' => bcrypt('123'),
        ]);
        $ayman->assignRole('admin');

        $omar = User::create([
            'name' => 'عمر سنبل',
            'email' => 'omar@awontech.sa',
            'password' => bcrypt('123'),
        ]);
        $omar->assignRole('admin');

        $omar = User::create([
            'name' => 'لجين صلاح',
            'email' => 'lujain@awontech.sa',
            'password' => bcrypt('123'),
        ]);
        $omar->assignRole('employee');
    }
}
