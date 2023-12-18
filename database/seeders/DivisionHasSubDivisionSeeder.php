<?php

namespace Database\Seeders;

use App\Models\DivisionHasSubDivision;
use Illuminate\Database\Seeder;

class DivisionHasSubDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->runDataFake();
    }

    public function runDataFake(): void
    {
        DivisionHasSubDivision::factory()->count(15)->create();
    }
}
