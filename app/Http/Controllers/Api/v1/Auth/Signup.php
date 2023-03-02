<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Signup extends Controller
{
    /**
     * Handle the incoming request. Signup new user
     * 
     * @param App\Http\Requests\SignupRequest  $request
     * @return Illuminate\Http\Response
     */
    public function __invoke(SignupRequest $request)
    {
        $validated = $request->validated();

        // hash password
        $validated['password'] = Hash::make($validated['password']);

        // store user
        $user = User::create($validated);

        if (!$user) {
            return response()->json([
                'message' => 'User was not registered'
            ], 400);
        }

        // store token
        $token = $user->createToken($user->name.'-token', []);

        return response()->json([
            'success' => true,
            'message' => __('Successfully registered'),
            'user' => $user,
            'token' => $token->plainTextToken
        ], 201);
    }
}
