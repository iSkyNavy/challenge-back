<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->runDataDefault();
        $this->runDataFake();
    }

    protected function runDataFake()
    {
        Division::factory()->count(29)->create();
    }

    private function runDataDefault()
    {
        Division::factory()->count(1)->create();
    }
}
