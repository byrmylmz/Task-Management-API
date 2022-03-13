<?php

namespace App\Actions\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Resources\Syncronization\SyncResource;



class ReorderCommand 
{
    use AsAction;


    public static function handle(array $items, string $classname, bool $fullSync){
       
        Gate::authorize('create categories', ReorderCommand::class);

        $class = '\App\Models\\'.$classname;
        $collection = collect();
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
        $responseItems=collect([$add->all()]);
        return $responseItems;
                   
    }

    
}

