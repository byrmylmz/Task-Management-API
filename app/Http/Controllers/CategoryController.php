<?php

namespace App\Http\Controllers;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryCollection;
use App\Models\Category;
use App\Models\Board;
use Google\Service\CloudSearch\Id;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\True_;

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
        $categories=Category::all();
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
        $categories=$request->input('categories');
     
        foreach($categories as $key => $categoryFront){
            
            $categoryBack=Category::find($categoryFront['id']);
            $categoryBack->update(
                [
                    'order'=>$categoryFront['order'],
                ]
            );
        
          if(!empty($categoryFront['boards'])){
              foreach($categoryFront['boards'] as $key => $boardFront){
                $boardBack=Board::find($boardFront['id']);
                $boardBack->update(
                    [
                        'order'=>$boardFront['order'],
                        'category_id'=>$boardFront['category_id'],
                    ]
                 );
              }
          }
        }


    }
}
