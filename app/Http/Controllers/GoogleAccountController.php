<?php

namespace App\Http\Controllers;

use App\Http\Resources\GoogleAccountResource;
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
        return GoogleAccountResource::collection($googleAccounts);

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

        $account = $google->service('Oauth2')->userinfo->get();

        auth::user()->googleAccounts()->updateOrCreate(
            [
                'google_id' => $account->id,
            ],
            [
                'name' => $account->email,
                'token' => $google->getAccessToken(),
            ]
        );

        return redirect('https://sanctum.alakod.com/google-account');
    }

    /**
     * Revoke the account's token and delete the it locally.
     */
    public function destroy(GoogleAccount $googleAccount, Google $google)
    {
        $googleAccount->delete();

        // Event though it has been deleted from our database,
        // we still have access to $googleAccount as an object in memory.
        $google->revokeToken($googleAccount->token);

        return response('Deleted Succesfully',200);

    }
}
