<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\ActionController;
use App\Models\Board;
use App\Models\Card;
use App\Models\Category;
use App\Models\Column;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class AddAction extends ActionController
{
    
    public static function category($items)
    {   
        $order = Category::max('order');
        
        $add = Category::create([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'temp_id'=>$items['temp_id'],
            'order'=>$order+1,
        ]);
        
        return $add->id;
    }

    public static function board($items)
    {   
        $order = Board::max('order');

        $add = Board::create([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'category_id'=>$items['category_id'],
            'temp_id'=>$items['temp_id'],
            'order'=>$order+1,
        ]);
        return $add->id;
    }

    public static function column($items)
    {   
        $order =Column::max('order');

        $add = Column::create([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'description'=>$items['description'],
            'board_id'=>$items['board_id'],
            'temp_id'=>$items['temp_id'],
            'order'=>$order+1,
        ]);
        return $add->id;
    }

    public static function card($items)
    {   
        $order =Card::max('order');

        $add = Card::create([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'column_id'=>$items['column_id'],
            'temp_id'=>$items['temp_id'],
            'order'=>$order+1,
        ]);
        return $add->id;
    }

    public static function task($items)
    {   
        $order =Task::max('order');

        $add = Task::create([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'description'=>$items['description'],
            'card_id'=>$items['card_id'],
            'temp_id'=>$items['temp_id'],
            'order'=>$order+1,
        ]);
        return $add->id;
    }
}
