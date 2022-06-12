<?php

namespace Database\Seeders;

use DateTime;
use Faker\Factory;
use App\Models\Card;
use App\Models\Task;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

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
                'description'=>$faker->text,
                'start'=> Carbon::now(),
                'end'=> Carbon::now('+01:00'),
                'order'=>1,

            ]);
            //second
            $card->tasks()->create([
                'title'=>$faker->word,
                'user_id'=>$card->user_id,
                'description'=>$faker->text,
                'start'=> Carbon::now(),
                'end'=> Carbon::now('+01:00'),
                'order'=>2,

            ]);
          });
    }
}
