<?php
namespace AppAuth\Auth\Http\Controllers;

use AppUser\User\Services\AuthService;
use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use RainLab\User\Models\User as UserModel;

class AuthController extends Controller {

    public function register(Request $request) {
        $data = $request->all();

        $user = new UserModel;
        $user->fill($data);
        $user->is_activated = true;
        $user->activated_at = now();
        $user->token = Str::random(60);
        $user->save();

        Auth::login($user);

        return [
            'message' => 'Registration successful',
            'token' => $user->token,
        ];
    }

    public function login(Request $request) {
        $credentials = $request->all();

        if (!Auth::attempt($credentials)) {
            return response(['message' => 'The provided credentials are incorrect.'], 422);
        }
        $user = Auth::getUser();
        $user->token = Str::random(60);
        $user->save();

        return [
            'message' => 'Login successful',
            'token' => $user->token,
            'user' => Auth::getUser()
        ];
    }

    public function logout() {
        $user = Auth::getUser();
        if (!$user) {
            return ['error' => 'User not found or already logged out',];
        }

        $user->token = null;
        $user->save();
        Auth::logout();
        return [
            'message' => 'Logout successful',
        ];
    }
}
