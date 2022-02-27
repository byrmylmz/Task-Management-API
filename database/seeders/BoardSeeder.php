<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
     
        Category::all()->each(function($category){

            $faker = Factory::create();
            //first
            $category->boards()->create([
                'title'=>$faker->word,
                'user_id'=>$category->user_id
            ]);
            //second
            // $category->boards()->create([
            //     'title'=>$faker->word,
            //     'user_id'=>$category->user_id
            // ]);
        });

    }
}
