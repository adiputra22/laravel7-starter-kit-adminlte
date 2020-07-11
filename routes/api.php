<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request) {
    
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return [
            'email' => ['The provided credentials are incorrect.'],
        ];
    }

    return $user->createToken('test-get-token')->plainTextToken;
});