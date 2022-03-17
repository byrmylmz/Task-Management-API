<?php

namespace App\Actions\Models;

use Illuminate\Support\Facades\Gate;
use App\Actions\Objects\ModelResultObject;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Controllers\SyncController;

class BoardModel 
{
    use AsAction;

    public static function handle($items,$action){
       
      Gate::authorize('create categories', ReorderCommand::class);

    //   $result = ModelResultObject::make();
     
      $collection =collect($items);
    //    $grouped = $collection->groupBy('type');
    //    $groups=$grouped->all();

    //    $groupName=array_keys($groups);

       foreach($collection as $item){
     
        //  $actionName= explode('_',$item['type'])[1];
        //App\Actions\Actions\BoardActions
        $nameSpace ="App\Actions\Actions\\".ucfirst($action."Action");

        return $nameSpace::run($collection);                 
    }
       
       
    }
}
