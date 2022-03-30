<?php

namespace App\Http\Controllers;

use App\Http\Resources\Board\BoardResource;
use App\Http\Resources\Board\BoardWithColumnResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{   
    /**
     * Permissions 
     */
    public function __construct()
    {
        $this->middleware('permission:see boards')->only('index');
        $this->middleware('permission:create boards')->only('store');
        $this->middleware('permission:updateAll boards')->only('updateAll');
        $this->middleware('permission:update boards')->only('update');
        $this->middleware('permission:delete boards')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\Board\BoardResource
     * 
     */

    public function index()
    {
        $boards=Board::orderBy('title')->get();
        return BoardResource::collection($boards);
       
       
    }

    /**
     * Display a listing of boards with column & cards & tasks
     *
     * @param  \App\Models\Board  $board
     * @return \App\Http\Resources\Board\BoardWithColumnResource
     */
    public function boardWithColumn(Board $board)
    {
       return new BoardWithColumnResource($board);
    
    }

    //----------------------------------------------------------------
    public function store(Request $request)
    {   
        $board = Board::create(
            [
                'user_id'=>auth()->user()->id,
                'title'=>$request->title,
                'order'=>1,
                'category_id'=>$request->category_id
                ]
            );
            
            return new BoardResource($board);

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

        return new BoardResource($board);
    }
    //----------------------------------------------------------------
    public function destroy(Board $board)
    {
        $board->delete();
        return new BoardResource($board);
    }
}
