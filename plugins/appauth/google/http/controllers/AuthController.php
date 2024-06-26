<?php
namespace AppAuth\Google\Http\Controllers;

use Backend\Classes\Controller;
use Illuminate\Support\Str;
use RainLab\User\Models\User;
use Auth;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();
        if (!$user) {
            $autoGeneratedPassword = Str::random(40);

            $user = Auth::register([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => $autoGeneratedPassword,
                'password_confirmation' => $autoGeneratedPassword,
                'is_activated' => true,
            ], true);
        } else {
            $user->google_token = $googleUser->token;
            $user->google_refresh_token = $googleUser->refreshToken;
            $user->save();
        }
        $user->token = Str::random(60);
        $user->save();

        Auth::login($user);

        return redirect()->to('/');
}
}
