<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Passport\TokenRepository;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();


        $user = User::where('provider_id', $googleUser->id)->first();

        if ($user) {
            $user->update([
                'provider_token' => $googleUser->token,
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'trial_until' => now()->addDays(config('app.free_trial_days')),
                'provider_name'=>'google',
                'provider_id' => $googleUser->id,
                'provider_token' => $googleUser->token,
            ]);
        }

        // delete all token first
        // actually I can revoke old token first.
        $user->tokens()->delete();
        // find role first then assign this solution i found.
        $roleToAssign = Role::findByName('trial', 'api');
        $user->assignRole($roleToAssign);

        $token = $user->createToken('google')->accessToken;
        //return the token for usage
        return response()->json([
            'success' => true,
            'token' => $token
        ]);

            
    }
 
}