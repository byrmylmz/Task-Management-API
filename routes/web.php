<?php

use App\Events\CalendarEventCreated;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAccountController;
use App\Http\Controllers\GoogleWebhookController;
use App\Events\Hello;

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
     |-----------------------------------------------
     |  GOOGLE LOGIN AND REGISTER.
     |-----------------------------------------------
     */
    Route::get('/auth/redirect',[LoginController::class,'redirectToProvider']);
    Route::get('/auth/callback',[LoginController::class,'handleProviderCallback']);

    Route::get('/google/oauth', [GoogleAccountController::class,'store']);
    Route::post('/google/webhook', GoogleWebhookController::class);



    Route::get('/broadcast',function(){
        $calendarId=9;
         CalendarEventCreated::dispatch($calendarId);
    });


