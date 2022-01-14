<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\TodosController;
use App\Models\Board;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        $users=User::pluck('id')->toArray();
        //return response($users);
        $random=Arr::random($users);
         return response($random);

       // return response(Arr::random($users));
       
    });

    Route::middleware('auth:api')->group(function(){
        /* User Information */
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        /* Todo list */
        Route::get('/todos',[TodosController::class,'index']);
        Route::post('/todos',[TodosController::class,'store']);
        Route::patch('/todos/{todo}',[TodosController::class,'update']);
        Route::patch('/todosCheckAll',[TodosController::class,'updateAll']);
        Route::delete('/todos/{todo}',[TodosController::class,'destroy']);
        Route::delete('/todosDeleteCompleted',[TodosController::class,'destroyCompleted']);
        Route::middleware('auth:api')->post('/logout', [AuthController::class,'logout']);

        /* Boards */
        Route::get('/boards',[BoardController::class,'index']);
        Route::post('/boards',[BoardController::class,'store']);
        Route::put('/boards/updateAll',[BoardController::class,'updateAll']);
        Route::patch('/boards/update/{board}',[BoardController::class,'update']);
        Route::delete('/boards/{board}',[BoardController::class,'destroy']);

        /* Columns */
        Route::get('/columns',[ColumnController::class,'index']);

        /* Category */
        Route::get('/categories',[CategoryController::class,'index']);
        Route::post('/categories',[CategoryController::class,'store']);
        Route::patch('/categories/{category}',[CategoryController::class,'update']);
        Route::delete('/categories/{category}',[CategoryController::class,'destroy']);
    });


    /**
     |----------------------------------
     | Auth Login and Register
     |----------------------------------
     */
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/register', [AuthController::class,'register']);

