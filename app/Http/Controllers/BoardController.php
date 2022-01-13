<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index()
    {
        return Board::all();
    }

    public function store(Request $request)
    {   

        /**
         * validation will be done later
         */

        Board::create(
            [
               'user_id'=>auth()->user()->id,
               'title'=>$request->title
            ]
        );

        return response('Successfully created', 200);
    }
}
