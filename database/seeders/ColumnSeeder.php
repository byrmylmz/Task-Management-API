<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Column;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

class ColumnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //Column::factory()->count(50)->create();
       Board::all()->each(function($board){

        $faker = Factory::create();
        //first
        $board->columns()->create([
            'title'=>$faker->word,
            'user_id'=>$board->user_id
        ]);
        //second
        // $board->columns()->create([
        //     'title'=>$faker->word,
        //     'user_id'=>$board->user_id
        // ]);
      });
    }
}
