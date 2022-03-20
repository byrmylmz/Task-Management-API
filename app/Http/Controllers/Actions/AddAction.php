<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\ActionController;
use App\Models\Board;
use App\Models\Card;
use App\Models\Category;
use App\Models\Column;
use App\Models\Task;

class AddAction extends ActionController
{
    public static function category($items)
    {   
        $add = Category::create([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
        ]);
        return $add->id;
    }

    public static function board($items)
    {
        $add = Board::create([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'category_id'=>$items['category_id']
        ]);
        return $add->id;
    }

    public static function column($items)
    {
        $add = Column::create([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'board_id'=>$items['board_id']
        ]);
        return $add->id;
    }

    public static function card($items)
    {
        $add = Card::create([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'column_id'=>$items['column_id']
        ]);
        return $add->id;
    }

    public static function task($items)
    {
        $add = Task::create([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'description'=>$items['description'],
            'card_id'=>$items['card_id']
        ]);
        return $add->id;
    }
}
