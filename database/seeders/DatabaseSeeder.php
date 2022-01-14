<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call([
        UserSeeder::class,
        CategorySeeder::class,
        BoardSeeder::class,
        ColumnSeeder::class,
        CardSeeder::class,
        TaskSeeder::class,
      ]);
      // \App\Models\User::factory(1)->create();
    }
}
