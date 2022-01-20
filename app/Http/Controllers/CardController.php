<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Permissions middlewares
     */
    public function __construct()
    {
        $this->middleware('permission:see cards')->only('index');
        $this->middleware('permission:create cards')->only('store');
        $this->middleware('permission:updateAll cards')->only('updateAll');
        $this->middleware('permission:update cards')->only('update');
        $this->middleware('permission:delete cards')->only('destroy');
    }
    //-------------------------------------------------------------------
    public function index()
    {
        $cards=Card::all();
        return response($cards);
        
    }
    //-------------------------------------------------------------------
    public function store(Request $request)
    {
        Card::create(
            [
                'user_id'=>auth()->user()->id,
                'title'=>$request->title,
                'column_id'=>$request->column_id,
                ]
            );
        
        return response('Created Successfully',200);
    }
        
    //-------------------------------------------------------------------
    public function update(Request $request, Card $card)
    {
        $card->update(
            [
                'title'=>$request->title
                ]
            );
            
            return response('Updated Successfully',200);
        }
    //-------------------------------------------------------------------
    public function destroy(Column $column)
    {
        $column->delete();
        return response('Deleted Successfully',200);
    }
}
