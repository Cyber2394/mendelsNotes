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
                'https://www.googleapis.com/auth/drive.metadata',
            ])
            ->with(['access_type' => 'offline'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $existingUser = User::where('email', $googleUser->email)->first();

        if ($existingUser) {
            $existingUser->update([
                'access_token' => $googleUser->token,
                'refresh_token' => $googleUser->refreshToken,
            ]);
            Auth::login($existingUser, true);
        } else {
            // Create a new user with the received Google user data
            $newUser = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt('your_default_password'),
                'access_token' => $googleUser->token,
                'refresh_token' => $googleUser->token,
            ]);

            Auth::login($newUser, true);
        }

        return redirect($this->redirectTo);
    }
}
