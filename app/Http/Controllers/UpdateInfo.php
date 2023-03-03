<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInfoRequest;
use App\Traits\GenerateUserToken;
use Illuminate\Http\Request;

class UpdateInfo extends Controller
{
    use GenerateUserToken;
    
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateInfoRequest $request)
    {
        $validated = $request->validated();

        // update
        $request->user()->update($validated);

        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        // store token
        $token = $this->generateUserToken($request->user(), []);

        return response()->json([
            'message' => __('Successfully updated'),
            'token' => $token->plainTextToken,
        ]);
    }
}
