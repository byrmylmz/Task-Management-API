<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ActionController;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Synchronization\FullSyncResource;

class SyncController extends Controller
{
    
    public function __invoke(Request $request)
    {   
        $fullSync=$request->full_sync;

        $collection =collect($request->commands);
        $action= new ActionController($collection);
        
       /**
        * Seperate Json Response Structure.
        */ 
       //return $fullSync ? new FullSyncResource('') : $action->result() ;
       
       /**
        * Nested Json Response Structure.
        */
        return $fullSync ?  CategoryResource::collection((auth()->user()->categories)->load('boards')) : $action->result() ;
       
        
    }
}
