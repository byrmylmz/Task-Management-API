<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $card_array=Card::pluck('id')->toArray();
        $user_array=Card::pluck('user_id')->toArray();

        return [
            'user_id'=>Arr::random($user_array),
            'title'=>$this->faker->word(),
            'description'=>$this->faker->word(),
            'card_id'=>Arr::random($card_array),
        ];
    }
}
