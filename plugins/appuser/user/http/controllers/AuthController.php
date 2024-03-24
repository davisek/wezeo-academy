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
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $user->token = Str::random(60);
        $user->save();

        return response()->json([
            'message' => 'Registration successful',
            'token' => $user->token,
        ]);
    }

    public function login(LoginRequest $request) {
        $credentials = $request->validated();

        if (!$user = User::where('username', $credentials['username'])->first()) {
            return response([
                'message' => 'Provided email address or password is incorrect!'
            ], 422);
        }

        if ($user->username && Hash::check($credentials['password'], $user->password)) {
            $user->token = Str::random(60);
            $user->save();
            return response()->json([
                'message' => 'Login successful',
                'token' => $user->token,
            ]);
        }
    }

    public function logout(Request $request) {
        $token = $request->bearerToken();

        $user = User::where('token', $token)->first();

        if ($user) {
            $user->token = null;
            $user->save();

            return response()->json([
                'message' => 'Logout successful',
            ]);
        }

        return response()->json([
            'error' => 'User not found or already logged out',
        ], 404);
    }
}
