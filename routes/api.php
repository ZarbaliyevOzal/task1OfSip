<?php

use App\Http\Controllers\Api\v1\Auth\SignIn;
use App\Http\Controllers\Api\v1\Auth\Signup;
use App\Http\Controllers\Api\v1\Profile;
use App\Http\Controllers\Api\v1\Auth\Token;
use App\Http\Controllers\Api\v1\Latency;
use App\Http\Controllers\UpdateInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('api.v1.')->prefix('v1')->group(function() {
    Route::post('/signup', Signup::class);
    Route::post('/signin', SignIn::class)->name('signin');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/info', Profile::class)->name('info');
        Route::put('/info', UpdateInfo::class)->name('info.update');
        Route::delete('/token', Token::class)->name('token');
        Route::get('/latency', Latency::class)->name('latency');
    });
});
