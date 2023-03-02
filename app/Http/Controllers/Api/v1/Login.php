<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\GenerateUserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Login extends Controller
{
    use GenerateUserToken;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        
        // find user
        $user = User::where('username', $validated['username'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'username' => [__('The provided credentials are incorrect.')],
            ]);
        }

        // limit user tokens
        if (count($user->tokens) >= 50) $user->tokens()->limit(1)->delete();

        // store token
        $token = $this->generateUserToken($user, []);

        return response()->json([
            'message' => __('Successfully logged in'),
            'user' => new UserResource($user),
            'token' => $token->plainTextToken,
        ], 200);
    }
}
