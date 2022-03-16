<?php

namespace App\Actions\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Resources\Syncronization\SyncResource;



class ReorderAction

{
    use AsAction;


    public static function handle( $items){
       
        Gate::authorize('create categories', ReorderCommand::class);

        
        return $items;
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

