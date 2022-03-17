<?php

namespace App\Actions\Actions;

use App\Actions\Objects\ActionsResultObject;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Controllers\SyncController;
use Illuminate\Queue\Jobs\SyncJob;

class ReorderAction 
{
    use AsAction;


    public static function handle($items,$model){
       
      
       // Gate::authorize('create categories', ReorderCommand::class);
        
       
       
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