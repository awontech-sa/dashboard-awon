<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Members;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Members::query()->create([
            'm_name' => 'رهف الثبيتي',
        ]);

        Members::query()->create([
            'm_name' => 'ربى العامودي',
        ]);

        Members::query()->create([
            'm_name' => 'لجين صلاح',
        ]);

        Members::query()->create([
            'm_name' => 'رغد مجلد',
        ]);

        Members::query()->create([
            'm_name' => 'مهند العمري',
        ]);
    }
}
