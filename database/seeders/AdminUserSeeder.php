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
            'phone_number' => '+966 56 888 5676'
        ]);
        $ayman->assignRole('Admin');

        $murooj = User::create([
            'name' => 'مروج الزهراني',
            'email' => 'lujain@awontech.sa',
            'password' => bcrypt('123'),
        ]);
        $murooj->assignRole('Employee');
    }
}
