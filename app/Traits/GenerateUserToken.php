<?php

namespace App\Traits;

trait GenerateUserToken {

    /**
     * Generate user token. Laravel sanctum
     * 
     * @param App\Models\User  $user
     * @param array  $abilities
     * @return object
     */
    public function generateUserToken($user, $abilities) {
        // store token
        return $user->createToken($user->username.'-token', $abilities);
    }

}