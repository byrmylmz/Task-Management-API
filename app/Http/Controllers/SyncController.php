<?php

namespace App\Http\Controllers;

use App\Actions\Models\CategoryModel;
use Illuminate\Http\Request;
use App\Actions\Objects\SyncResponseObject;
use App\Http\Resources\Synchronization\SyncResource;
use App\Http\Resources\Synchronization\FullSyncResource;

class SyncController extends Controller
{
    
    public function __invoke(Request $request)
    {   
        $fullSync=$request->full_sync;

        $collection =collect($request->commands);
        $action= new ActionController($collection);
      
        return $fullSync ? new FullSyncResource('') : $action->result() ;
         
         
        //return $collection->items;

         //return array_column($request->commands,'items');
        
        //  $grouped = $collection->groupBy('type');

        // $groups=$grouped->all();
        //   //return array_column($groups,'type');

        // $types=array_keys($groups);

        // foreach($types as $type){  
     
        //      $modelName= explode("_",$type)[0];
        //       $actionName= explode("_",$type)[1];

        //      //App\Actions\Models\BoardActions
        //      $nameSpace ="App\Actions\Actions\\".ucfirst($actionName."Action");

        //     return $nameSpace::run($groups['board_reorder'],$modelName);                 
        // }   
        // return $result;
        //return $fullSync ? new FullSyncResource('') : new SyncResource($result) ;
        
    }
}
