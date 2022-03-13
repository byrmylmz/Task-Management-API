<?php

namespace App\Actions\Commands;

use Lorisleiva\Actions\Concerns\AsObject;

class MoveCommand
{
    use AsObject;

    public function handle($item,$classname){
        $class = '\App\Models\\'.$classname;
        $class::find($item['item_id'])->update(['category_id'=>$item['category_id']]);
        
        return $class::find($item['item_id']);
       
    }
}
