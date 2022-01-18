<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    //-------------------------------------------------------------------
    public function index()
    {
        $columns=Column::all();
        return response($columns);
        
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
