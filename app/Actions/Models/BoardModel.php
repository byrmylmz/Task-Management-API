<?php

namespace App\Actions\Models;

use Illuminate\Support\Facades\Gate;
use App\Actions\Objects\ActionsResultObject;
use Lorisleiva\Actions\Concerns\AsAction;

class BoardModel
{
    use AsAction;

    public static function handle($items){
       
       Gate::authorize('create categories', ReorderCommand::class);

       $result = ActionsResultObject::make();

       $collection =collect($items);
       $grouped = $collection->groupBy('action');
       $groups=$grouped->all();

       $groupName=array_keys($groups);

       foreach($groupName as $action){

        //App\Actions\Actions\BoardActions
        $nameSpace ="App\Actions\Actions\\".ucfirst($action."Action");

        $result->arg = $nameSpace::run($groups[$action]);                 
    }
        return $result;
       
    }
}
