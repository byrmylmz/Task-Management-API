<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
     /**
     |-----------------------------------------------------------
     | index
     |-----------------------------------------------------------
     */
    public function index()
    {
        return Board::orderBy('order','DESC')->get();
    }
    /**
     |-----------------------------------------------------------
     | Store
     |-----------------------------------------------------------
     */
    public function store(Request $request)
    {   

        //validation will be later

        Board::create(
            [
               'user_id'=>auth()->user()->id,
               'title'=>$request->title
            ]
        );

        return response('Successfully created', 200);
    }
    /**
     |-----------------------------------------------------------
     | Update all
     |-----------------------------------------------------------
     */
    public function updateAll(Request $request)
    {
        $boards = Board::all();
        foreach ($boards as $board){
            $board->timestamp= false;
            $id = $board->id;
            foreach($request->boards as $boardFontEnd){
                if($boardFontEnd['id']==$id){
                    $board->update(['order'=>$boardFontEnd['order']]);
                }
            }

        }
        return response('tamamdir',200);


    }
}
