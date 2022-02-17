<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleAccountController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PassportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodosController;
use App\Http\Controllers\UserController;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserBasicResource;
use App\Http\Resources\UserResource;
use App\Models\Board;
use App\Models\User;
use App\Models\Category;
use App\Models\Message;
use App\Scopes\UserIdScope;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;






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

Route::middleware(['auth:sanctum','trial'])->group(function(){
        // google accounts
        Route::get('/gaccounts', [GoogleAccountController::class,'index']);
        Route::delete('/google/{googleAccount}', [GoogleAccountController::class,'destroy']);
        Route::get('/events',[EventController::class,'index']);

        /* Sanctum authentication */
        Route::get('/users/auth',AuthController::class);
        Route::get('/users/{user}',[UserController::class,'show']);
        Route::get('/users',[UserController::class,'index']);

        // Avatar will be handle or cancel
        Route::get('/messages',[MessageController::class,'index']);
        Route::post('/messages',[MessageController::class,'store']);

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
        //Route::middleware('auth:api')->post('/logout', [AuthController::class,'logout']);
        
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
     | Third Party Register
     |----------------------------------
     */
    
        // Route::post('/login', [AuthController::class,'login']);
        // Route::post('/register', [AuthController::class,'register']);
        // Route::post('/oauth/token', [PassportController::class,'auth']);
        Route::post('/sanctum/token', function (Request $request) {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            return $user->createToken($request->device_name)->plainTextToken;
        });


