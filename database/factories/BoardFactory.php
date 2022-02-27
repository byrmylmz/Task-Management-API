<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category_array=Category::pluck('id')->toArray();
        $user_array=Category::pluck('user_id')->toArray();
        
        return [
            'user_id'=>Arr::random($user_array),
            'category_id'=>Arr::random($category_array),
            'title'=>$this->faker->word(),
        ];
    }
}
