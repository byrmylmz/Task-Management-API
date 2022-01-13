<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\TodosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
    Route::fallback(function(){
        return response()->json([
            'message' => 'Page Not Found. If error persists, contact bayramyilmaz061@gmail.com'], 404);
    });


    Route::get('/test',function(){
        return response('test');
    })->middleware('auth:api');

    Route::middleware('auth:api')->group(function(){
        /**
         * user information
         */
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        /**
         * todo list 
         */
        Route::get('/todos',[TodosController::class,'index']);
        Route::post('/todos',[TodosController::class,'store']);
        Route::patch('/todos/{todo}',[TodosController::class,'update']);
        Route::patch('/todosCheckAll',[TodosController::class,'updateAll']);
        Route::delete('/todos/{todo}',[TodosController::class,'destroy']);
        Route::delete('/todosDeleteCompleted',[TodosController::class,'destroyCompleted']);
        Route::middleware('auth:api')->post('/logout', [AuthController::class,'logout']);
        /**
         * Boards api list
         */
        Route::get('boards',[BoardController::class,'index']);
        Route::post('boards',[BoardController::class,'store']);
        Route::put('updateAll',[BoardController::class,'updateAll']);
    });


    /**
     |----------------------------------
     | Auth Login and Register
     |----------------------------------
     */
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/register', [AuthController::class,'register']);
