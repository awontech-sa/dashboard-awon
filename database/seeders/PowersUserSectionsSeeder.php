<?php

namespace Database\Seeders;

use App\Models\PowersUserSections;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PowersUserSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PowersUserSections::create(['powers_id' => 1, 'powers_sections_id' => 1, 'user_id' => 1]);
        PowersUserSections::create(['powers_id' => 2, 'powers_sections_id' => 2, 'user_id' => 1]);
        PowersUserSections::create(['powers_id' => 3, 'powers_sections_id' => 3, 'user_id' => 1]);
        PowersUserSections::create(['powers_id' => 1, 'powers_sections_id' => 4, 'user_id' => 1]);
        PowersUserSections::create(['powers_id' => 2, 'powers_sections_id' => 5, 'user_id' => 1]);
        PowersUserSections::create(['powers_id' => 3, 'powers_sections_id' => 6, 'user_id' => 1]);

        PowersUserSections::create(['powers_id' => 1, 'powers_sections_id' => 1, 'user_id' => 2]);
        PowersUserSections::create(['powers_id' => 2, 'powers_sections_id' => 2, 'user_id' => 2]);
        PowersUserSections::create(['powers_id' => 3, 'powers_sections_id' => 3, 'user_id' => 2]);
        PowersUserSections::create(['powers_id' => 1, 'powers_sections_id' => 4, 'user_id' => 2]);
        PowersUserSections::create(['powers_id' => 2, 'powers_sections_id' => 5, 'user_id' => 2]);
        PowersUserSections::create(['powers_id' => 3, 'powers_sections_id' => 6, 'user_id' => 2]);

        PowersUserSections::create(['powers_id' => 1, 'powers_sections_id' => 1, 'user_id' => 3]);
        PowersUserSections::create(['powers_id' => 2, 'powers_sections_id' => 2, 'user_id' => 3]);
        PowersUserSections::create(['powers_id' => 3, 'powers_sections_id' => 3, 'user_id' => 3]);
        PowersUserSections::create(['powers_id' => 1, 'powers_sections_id' => 4, 'user_id' => 3]);
        PowersUserSections::create(['powers_id' => 2, 'powers_sections_id' => 5, 'user_id' => 3]);
        PowersUserSections::create(['powers_id' => 3, 'powers_sections_id' => 6, 'user_id' => 3]);
    }
}
