<?php

namespace App\Http\Controllers;

use App\Actions\Commands\MoveCommand;
use App\Http\Resources\Category\CategoryCollection;
use App\Models\Category;
use App\Models\Board; // keep it here
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Actions\Commands\ReorderCommand;
use App\Actions\Objects\SyncResponse;
use App\Http\Resources\Syncronization\SyncResource;

class CategoryController extends Controller 
{
    /**
     * Permissions 
     */
    public function __construct()
    {
        $this->middleware('permission:see categories')->only('index');
        $this->middleware('permission:create categories')->only('store');
        $this->middleware('permission:updateAll categories')->only('updateAll');
        $this->middleware('permission:update categories')->only('update');
        $this->middleware('permission:delete categories')->only('destroy');
        //$this->middleware('permission:delete categories')->only('test');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=Category::all();
        return response($categories);
    }
    /**
     * Categories with Boards
     */

     public function categoriesWithBoards()
     {
        $categories=Category::orderBy('order')->get();
        return new CategoryCollection($categories);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Category::create([
            'user_id'=>auth()->user()->id,
            'title'=>$request->title
        ]);
        return response('Saved',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
       
        $category->update(
            [
                'user_id'=>auth()->user()->id,
                'title'=>$request->title
            ]
            );

            return response('Updated',200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response('Deleted',200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request)
    {   
       
        $fullSync=$request->full_sync;
       
        $result = SyncResponse::make();

       // return response($result->user_settings='deneme');
        foreach($request->commands as $action){

            $command = Str::after($action['type'],'_');
            $slice = Str::before($action['type'],'_');
            $class = Str::headline($slice);
            // $property = Str::lower($classname);
            // $propertyName = Str::of($property)->append('s');

            match($command){
                'moved' => $result->moved = MoveCommand::run($action['items'],$class) , //
                'reorder'=> $result->boards = ReorderCommand::run($action['items'],$class,$fullSync),//
                'default'=>'unknown status code'
            };                   
        }
        
        return new SyncResource($result);
        
    }

   

   
}


