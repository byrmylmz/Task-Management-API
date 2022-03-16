<?php

namespace App\Actions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class ReorderAction
{
    use AsAction;


    public static function handle( $items){
       
        //Gate::authorize('create categories', ReorderCommand::class);

        
        return $items;
        foreach($items as $item){return $item;}
        // $class = '\App\Models\\'.$classname;
        // $collection = collect();
        // foreach($items as $item){
        //      $class::find($item['id'])->update(['order'=>$item['order']]);
        //      $it=$class::find($item['id']);
        //         $add = $collection->push(
        //             [
        //                 'id'=>$it->id,
        //                 'title'=>$it->title,
        //                 'order'=>$it->order
        //             ]
        //         );
        // }
        // $responseItems=collect([$add->all()]);
        // return $responseItems;
                   
    }

    
}