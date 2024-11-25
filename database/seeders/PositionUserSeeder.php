<?php

namespace Database\Seeders;

use App\Models\PositionUser;
use Illuminate\Database\Seeder;

class PositionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PositionUser::create(['users_id' => 1, 'positions_id' => 1]);
        PositionUser::create(['users_id' => 2, 'positions_id' => 1]);
    }
}
