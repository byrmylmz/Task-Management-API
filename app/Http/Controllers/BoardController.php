<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    //----------------------------------------------------------------
    public function index()
    {
        return Board::orderBy('order')->get();
    }
    //----------------------------------------------------------------
    public function store(Request $request)
    {   
        Board::create(
            [
                'user_id'=>auth()->user()->id,
                'title'=>$request->title,
                'category_id'=>$request->category_id
                ]
            );
            
            return response('Successfully created', 200);
        }
    //----------------------------------------------------------------
    public function updateAll(Request $request)
    {
        $boards = Board::all();
        foreach ($boards as $board){
            $board->timestamps = false;
            $id = $board->id;
            foreach($request->boards as $boardFontEnd){
                if($boardFontEnd['id']==$id){
                    $board->update(['order'=>$boardFontEnd['order']]);
                }
            }
        }
        return response($boards);
    }
    //----------------------------------------------------------------
    public function update(Request $request, Board $board)
    {
        $data = $request->validate([
            'title'=>'required|string',
        ]);
        $board->update($data);
        return response($board,200);
    }
    //----------------------------------------------------------------
    public function destroy(Board $board)
    {
        $board->delete();
        return response('deleted',200);
    }
}
