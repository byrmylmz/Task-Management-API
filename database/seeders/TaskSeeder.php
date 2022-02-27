<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Faker\Factory;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Task::factory()->count(1000)->create();
        Card::all()->each(function($card){

            $faker = Factory::create();
            //first
            $card->tasks()->create([
                'title'=>$faker->word,
                'user_id'=>$card->user_id,
                'description'=>$faker->text

            ]);
            //second
            $card->tasks()->create([
                'title'=>$faker->word,
                'user_id'=>$card->user_id,
                'description'=>$faker->text

            ]);
          });
    }
}
