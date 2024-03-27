<?php
namespace AppUser\User\Http\Controllers;

use AppUser\User\Http\Requests\LoginRequest;
use AppUser\User\Http\Requests\RegisterRequest;
use AppUser\User\Services\AuthService;
use AppUser\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class AuthController extends Controller {

    public function register(RegisterRequest $request) {
        $data = $request->validated();

        $user = User::create($data);

        $user->token = Str::random(60);
        $user->save();

        return [
            'message' => 'Registration successful',
            'token' => $user->token,
        ];
    }

    public function login(LoginRequest $request) {
        $credentials = $request->validated();
        $user = User::where('username', $credentials['username'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response([
                'message' => 'Provided email address or password is incorrect!'
            ], 422);
        }

        $user->token = Str::random(60);
        $user->save();
        return [
            'message' => 'Login successful',
            'token' => $user->token,
        ];
    }

    public function logout(Request $request) {
        $user = AuthService::getUserByToken($request);

        if (!$user) {
            return ['error' => 'User not found or already logged out',];
        }

        $user->token = null;
        $user->save();

        return [
            'message' => 'Logout successful',
        ];
    }
}
