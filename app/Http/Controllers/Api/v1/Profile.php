<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Traits\GenerateUserToken;
use Illuminate\Http\Request;

class Profile extends Controller
{
    use GenerateUserToken;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // Revoke the token that was used to authenticate the current request...
        $user->currentAccessToken()->delete();

        // store token
        $token = $this->generateUserToken($user, []);

        return response()->json([
            'token' => $token->plainTextToken,
            'user' => new UserResource($user),
        ]);
    }
}
