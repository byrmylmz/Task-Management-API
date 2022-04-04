<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory;



class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Category::factory()->count(2)->create();
      $order =1;
      User::all()->each(function($user){

        $faker = Factory::create();
        //first
        $user->categories()->create([
            'title'=>$faker->word,
            'user_id'=>$user->id,
            'order'=>$order+1,
        ]);
        //second
        $user->categories()->create([
            'title'=>$faker->word,
            'user_id'=>$user->id,
            'order'=>$order+1,
        ]);
    });
      
    }
}
