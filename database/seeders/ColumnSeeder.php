<?php

namespace Database\Seeders;

use App\Models\Column;
use App\Models\User;
use Illuminate\Database\Seeder;

class ColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Column::factory()->count(3)->create();
    }
}
