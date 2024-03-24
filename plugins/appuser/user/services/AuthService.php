<?php

namespace AppUser\User\Services;

use AppUser\User\Models\User;

class AuthService
{
    /**
     * Získa používateľa na základe poskytnutého tokenu.
     *
     * @param  string $token
     * @return User|null
     */
    public static function getUserByToken($token)
    {
        if ($token != NULL) {
            return User::where('token', $token)->first();
        }
    }
}
