<?php

use App\Models\Calendar;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('created-events', function () {
    return true;
    // $google_accounts=$user->googleAccounts;
    // $account=$calendar->google_account_id;
    // return Arr::exists($google_accounts,$account);
});
    


