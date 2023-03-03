<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Traits\GenerateUserToken;
use Illuminate\Http\Request;

class Token extends Controller
{
    use GenerateUserToken;
    
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        // store token
        $token = $this->generateUserToken($request->user(), []);

        return response()->json([
            'message' => __('Token was successfully deleted'),
            'token' => $token->plainTextToken,
        ]);
    }
}
