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
        $murooj = User::create([
            'name' => 'مروج الزهراني',
            'email' => 'murooj@awontech.sa',
            'password' => bcrypt('123'),
        ]);
        $murooj->assignRole('Admin');

        $manar = User::create([
            'name' => 'منار آل ماشي',
            'email' => 'manar@awontech.sa',
            'password' => bcrypt('123'),
        ]);
        $manar->assignRole('Admin');
    }
}
