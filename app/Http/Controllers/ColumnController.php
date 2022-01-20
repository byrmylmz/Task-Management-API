<?php

namespace App\Http\Controllers;

use App\Http\Resources\Column\ColumnCollection;
use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{   
     /**
     * Permissions middlewares
     */
    public function __construct()
    {
        $this->middleware('permission:see columns')->only('index');
        $this->middleware('permission:create columns')->only('store');
        $this->middleware('permission:updateAll columns')->only('updateAll');
        $this->middleware('permission:update columns')->only('update');
        $this->middleware('permission:delete columns')->only('destroy');
    }

    //-------------------------------------------------------------------
    public function index()
    {
        $columns=Column::all();
        return response($columns);
        
    }

    /**
     * Column with cards and tasks api
     */
    public function columnWithCardsAndTasks()
    {
        $columns=Column::all();
        return new ColumnCollection($columns);
    }

    //-------------------------------------------------------------------
    public function store(Request $request) 
    {
        Column::create([
            'user_id'=>auth()->user()->id,
            'title'=>$request->title,
            'board_id'=>$request->board_id
        ]);

        return response('Created Successfully',200);
    }
    //-------------------------------------------------------------------
    public function update(Request $request, Column $column)
    {
        $column->update([
            'title'=>$request->title
        ]);
        
        return response('Updated Successfully',200);
    }
    //-------------------------------------------------------------------
    public function destroy(Request $reques,Column $column )
    {
        $column->delete();
        return response('Delete Successfully',200);
    }
}
