<?php

namespace App\Actions\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class MoveAction

{
    use AsAction;

    public function handle($item,$classname){
        $class = '\App\Models\\'.$classname;
        $class::find($item['item_id'])->update(['category_id'=>$item['category_id']]);
        
        return $class::find($item['item_id']);
       
    }
}
