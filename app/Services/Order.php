<?php

namespace App\Services;
use App\Models\Board;
use App\Models\Category;
use Illuminate\Support\Collection;

/**
 * @todo Add all model here
 * @todo write doc block.
 * 
 */
class Order 
{
    public static function order($items, $classname){
        $class = '\App\Models\\'.$classname;
        $collection=new Collection([]);
        foreach($items as $item){
             $class::find($item['id'])->update(['order'=>$item['order']]);
             $it=$class::find($item['id']);
                $add = $collection->push(
                    [
                        'id'=>$it->id,
                        'title'=>$it->title,
                        'order'=>$it->order
                    ]
                );
             
        }

        $col=collect(['data'=>$add->all()]);
        return $col->toJson();
        
    }

}







