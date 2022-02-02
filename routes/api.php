<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodosController;
use App\Models\Board;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->stateless()
     ->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->stateless()->user();

    return response($user->token());
});

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
        
    });

    Route::middleware(['auth:api','trial'])->group(function(){
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
        
        /* Category */
        Route::get('/categories',[CategoryController::class,'index']);
        Route::get('/categories-with-boards',[CategoryController::class,'categoriesWithBoards']);
        Route::post('/categories',[CategoryController::class,'store']);
        Route::patch('/categories/{category}',[CategoryController::class,'update']);
        Route::delete('/categories/{category}',[CategoryController::class,'destroy']);

        /* Boards */
        Route::get('/boards',[BoardController::class,'index']);
        Route::post('/boards',[BoardController::class,'store']);
        Route::put('/boards/updateAll',[BoardController::class,'updateAll']);
        Route::patch('/boards/{board}',[BoardController::class,'update']);
        Route::delete('/boards/{board}',[BoardController::class,'destroy']);

        /* Columns */
        Route::get('/columns',[ColumnController::class,'index']);
        Route::get('/column-with-cards-and-tasks',[ColumnController::class,'columnWithCardsAndTasks']);
        Route::post('/columns',[ColumnController::class,'store']);
        Route::patch('/columns/{column}',[ColumnController::class,'update']);
        Route::delete('/columns/{column}',[ColumnController::class,'destroy']);
        
        /* Cards */
        Route::get('/cards',[CardController::class,'index']);
        Route::post('/cards',[CardController::class,'store']);
        Route::patch('/cards/{card}',[CardController::class,'update']);
        Route::delete('/cards/{card}',[CardController::class,'destroy']);

        /* Tasks */
        Route::get('/tasks',[TaskController::class,'index']);
        Route::post('/tasks',[TaskController::class,'store']);
        Route::patch('/tasks/{task}',[TaskController::class,'update']);
        Route::delete('/tasks/{task}',[TaskController::class,'destroy']);
        
    });


    /**
     |----------------------------------
     | Auth Login and Register
     |----------------------------------
     */
    Route::post('/oauth/token', [PassportController::class,'auth']);
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/register', [AuthController::class,'register']);

