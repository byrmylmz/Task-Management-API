<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{   
    /**
     * Permissions middlewares
     */
    public function __construct()
    {
        $this->middleware('permission:see boards')->only('index');
        $this->middleware('permission:create boards')->only('store');
        $this->middleware('permission:updateAll boards')->only('updateAll');
        $this->middleware('permission:update boards')->only('update');
        $this->middleware('permission:delete boards')->only('destroy');
    }
    //----------------------------------------------------------------
    public function index()
    {
        $boards=Board::orderBy('order')->get();
        return response($boards);
       
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
