<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\ActionController;
use App\Models\Board;
use App\Models\Card;
use App\Models\Category;
use App\Models\Column;
use App\Models\Task;

class UpdateAction extends ActionController
{
    public static function category($items)
    {   
        $find=Category::find($items['id']);
        $find->update([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
        ]);
        return $find->id;
    }

    public static function board($items)
    {   
        $find=Board::find($items['id']);
        $find->update([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            // 'category_id'=>$items['category_id']
        ]);
        return $find->id;
    }

    public static function column($items)
    {   
        $find=Column::find($items['id']);
        $find->update([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            // 'board_id'=>$items['board_id']
        ]);
        return $find->id;
    }

    public static function card($items)
    {   
        $find=Card::find($items['id']);
        $find->update([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'description'=>$items['description'],
            'start'=>$items['start'],
            'end'=>$items['end'],
            // 'column_id'=>$items['column_id']
        ]);
        return $find->id;
    }

    public static function task($items)
    {   
        $find=Task::find($items['id']);
        $find->update([
            'user_id'=>auth()->user()->id,
            'title'=>$items['title'],
            'description'=>$items['description'],
            'start'=>$items['start'],
            'end'=>$items['end'],
            // 'card_id'=>$items['card_id']
        ]);
        return $find->id;
    }
}
