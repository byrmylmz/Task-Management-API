<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Card;
use App\Models\Column;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Card::factory()->count(1000)->create();
        Column::all()->each(function($column){

            $faker = Factory::create();
            //first
            $column->cards()->create([
                'title'=>$faker->word,
                'user_id'=>$column->user_id,
                'order'=>1,
                'start'=> Carbon::now(),
                'end'=> Carbon::now('+01:00'),

            ]);
            //second
            $column->cards()->create([
                'title'=>$faker->word,
                'user_id'=>$column->user_id,
                'order'=>2,
                'start'=> Carbon::now(),
                'end'=> Carbon::now('+01:00'),

            ]);
          });
    }
}
