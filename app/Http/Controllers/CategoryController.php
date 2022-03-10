<?php

namespace App\Http\Controllers;

use App\Http\Resources\Board\BoardResource;
use App\Http\Resources\Category\CategoryCollection;
use App\Models\Category;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\Order;


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
        $data=$request->input('data');

        foreach($data as $action){

            $command = Str::after($action['command'],'_');
            switch($command){

                case 'moved':
                    $slice=Str::before($action['command'],'_');
                    $class=Str::headline($slice);
                    $this->move($action['items'],$class);
                    break;

                case 'reorder':
                    $slice=Str::before($action['command'],'_');
                    $class=Str::headline($slice);
                    $response=Order::order($action['items'],$class);
                    return response($response);
                    break;
            }
        }
    }

    public function move($item,$classname){
        $class = '\App\Models\\'.$classname;
        $class::find($item['item_id'])->update(['category_id'=>$item['category_id']]);
        return response('test');
    }

   
}
