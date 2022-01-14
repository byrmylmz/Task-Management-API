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
    }
}
