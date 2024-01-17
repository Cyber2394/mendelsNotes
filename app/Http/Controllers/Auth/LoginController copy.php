<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes([
                'https://www.googleapis.com/auth/documents.readonly',
                'https://www.googleapis.com/auth/drive.file',
                'https://www.googleapis.com/auth/plus.login', // Include 'offline' scope
            ])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        // return response()->json($user ->approvedScopes);

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            $existingUser->update([
                'access_token' => $user->token,
            ]);
            Auth::login($existingUser, true);
        } else {
            // Create a new user with the received Google user data
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt('your_default_password'),
                'access_token' => $user->token,
                'refresh_token' => $user->refreshToken, // Store the refresh token if available
            ]);

            Auth::login($newUser, true);
        }
        return redirect($this->redirectTo);
    }
}
