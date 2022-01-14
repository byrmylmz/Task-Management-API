<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $array=User::pluck('id')->toArray();
        return [
            'user_id'=>Arr::random($array),
            'title'=>$this->faker->word(),
        ];
    }
}
