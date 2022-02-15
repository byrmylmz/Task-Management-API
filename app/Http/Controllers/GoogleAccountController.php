<?php

namespace App\Http\Controllers;

use App\Models\GoogleAccount;
use App\Services\Google;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleAccountController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

        /**
     * Display a listing of the google accounts.
     */
    public function index()
    {
       
        $googleAccounts= auth()->user()->googleAccounts;
        return response($googleAccounts);

    }

    /**
     * Handle the OAuth connection which leads to 
     * the creating of a new Google Account.
     */
    public function store(Request $request, Google $google)
    {
        if (! $request->has('code')) {
            return redirect($google->createAuthUrl());
        }
       
        $google->authenticate($request->get('code'));

        $account = $google->service('Oauth2');
        $userInfo = $account->userinfo->get();

        Auth::user()->googleAccounts()->updateOrCreate(
            [
                'google_id' => $userInfo->id,
            ],
            [
                'name' =>$userInfo->email,
                'token' => $google->getAccessToken(),
            ]
        );
    }

    /**
     * Revoke the account's token and delete the it locally.
     */
    public function destroy(GoogleAccount $googleAccount)
    {
        // TODO
    }
}
