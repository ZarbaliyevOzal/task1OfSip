<?php

use App\Http\Controllers\Api\v1\Auth\Signup;
use App\Http\Controllers\Api\v1\Login;
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

Route::name("api.v1.")->prefix("v1")->group(function() {
    Route::post("/signup", Signup::class);
    Route::post('/login', Login::class)->name('login');
});
