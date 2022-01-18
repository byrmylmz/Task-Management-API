<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ColumnFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $board_array=Board::pluck('id')->toArray();
        $user_array=User::pluck('id')->toArray();

        return [
            'user_id'=>Arr::random($user_array),
            'title'=>$this->faker->word(),
            'board_id'=>Arr::random($board_array),
            
        ];
    }
}
