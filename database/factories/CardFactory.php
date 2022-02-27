<?php

namespace Database\Factories;

use App\Models\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $column_array=Column::pluck('id')->toArray();
        $user_array=Column::pluck('user_id')->toArray();

        return [
            'user_id'=>Arr::random($user_array),
            'title'=>$this->faker->word(),
            'column_id'=>Arr::random($column_array),
        ];
    }
}
