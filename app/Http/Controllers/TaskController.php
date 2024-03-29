<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Permissions middlewares
     */
    public function __construct()
    {
        $this->middleware('permission:see tasks')->only('index');
        $this->middleware('permission:create tasks')->only('store');
        $this->middleware('permission:updateAll tasks')->only('updateAll');
        $this->middleware('permission:update tasks')->only('update');
        $this->middleware('permission:delete tasks')->only('destroy');
    }
    
    //-------------------------------------------------------------------
    public function index()
    {
        $tasks=Task::all();
        return response($tasks);
    }
    //-------------------------------------------------------------------
    public function store(Request $request)
    {
        Task::create([
            'user_id'=>auth()->user()->id,
            'card_id'=>$request->card_id,
            'description'=>$request->description,
            'title'=>$request->title,
        ]);
        return response('Successfully created',200);
    }
    //-------------------------------------------------------------------
    public function update(Request $request,Task $task)
    {
        $task->update(
            [
                'title'=>$request->title,
                'description'=>$request->description,
                ]
            );
            
            return response('Updated Successfully',200);
            
        }
    //-------------------------------------------------------------------
    public function destroy(Task $task)
    {
        $task->delete();
        return response('Deleted Successfully',200);
    }    
}
