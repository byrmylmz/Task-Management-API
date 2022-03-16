<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actions\Objects\SyncResponseObject;
use App\Http\Resources\Synchronization\SyncResource;
use App\Http\Resources\Synchronization\FullSyncResource;

class SyncController extends Controller
{
    public function __invoke(Request $request)
    {   
        $fullSync=$request->full_sync;

        $result = SyncResponseObject::make();

        $collection =collect($request->commands);
        
        $grouped = $collection->groupBy('type');
        $groups=$grouped->all();

        $groupName=array_keys($groups);

        foreach($groupName as $model){

            //App\Actions\Models\BoardActions
            $nameSpace ="App\Actions\Models\\".ucfirst($model."Model");

            $result->$model = $nameSpace::run($groups[$model]);                 
        }
        
        return $fullSync ? new FullSyncResource('') : new SyncResource($result) ;
        
    }
}
