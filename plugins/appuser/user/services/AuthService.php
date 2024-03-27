<?php

namespace AppUser\User\Services;

use AppUser\User\Models\User;
use Illuminate\Http\Request;

class AuthService
{

    public static $user = null;

    /**
     * Získa používateľa na základe poskytnutého tokenu.
     *
     * @param  string $token
     * @return User|null
     */

    public static function getUserByToken(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return null;
        }
        return SELF::$user = User::where('token', $token)->first();
    }

    public static function getUser() {
        return SELF::$user;
    }
}
