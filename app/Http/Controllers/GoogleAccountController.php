<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // TODO
    }

    /**
     * Revoke the account's token and delete the it locally.
     */
    public function destroy(GoogleAccount $googleAccount)
    {
        // TODO
    }
}
