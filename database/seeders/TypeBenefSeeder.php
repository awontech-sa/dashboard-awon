<?php

namespace Database\Seeders;

use App\Models\TypeBenef;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeBenefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeBenef::create(['tb_name' => "جهة"]);
        TypeBenef::create(['tb_name' => "أفراد"]);
    }
}
