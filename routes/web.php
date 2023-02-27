<?php

use App\Models\Calendar;
use Illuminate\Support\Str;
use App\Events\CalendarSync;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GoogleAccountController;
use App\Http\Controllers\GoogleWebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

    /**
     /-----------------------------------------------
     |  GOOGLE LOGIN AND REGISTER.
     |-----------------------------------------------
     */
    Route::get('/auth/redirect',[LoginController::class,'redirectToProvider']);
    Route::get('/auth/callback',[LoginController::class,'handleProviderCallback']);

    Route::get('/google/oauth', [GoogleAccountController::class,'store']);
    Route::post('/google/webhook', GoogleWebhookController::class);


    // broadcast test
    Route::get('/broadcast',function(){
        $userId=4;
        CalendarSync::dispatch($userId);
    });

    // redis test
    Route::get('/redis',function(){
       $redis = Redis::connection();
    try {
        var_dump($redis->ping());
    } catch (Exception $e){
            $e->getMessage();
        }
     
    });



 
    
   


