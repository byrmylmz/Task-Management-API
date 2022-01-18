<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\Request;

class CardController extends Controller
{
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
