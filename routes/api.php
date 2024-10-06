<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('/example', function () {
    return response()->json(['message' => 'Hello from Laravel API!']);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/register', [RegisteredUserController::class, 'store']);
// Route::middleware(['auth:sanctum'])->post('/user/register', [RegisteredUserController::class, 'store']);
// Route::post('/user/register', function (Request $request) {
//     // 유효성 검사
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'email' => 'required|string|email|max:255|unique:users',
//         'password' => 'required|string|min:8',
//     ]);

//     // 사용자 생성
//     $user = User::create([
//         'name' => $request->name,
//         'email' => $request->email,
//         'password' => Hash::make($request->password),
//     ]);

//     return response()->json(['message' => 'User registered successfully'], 201);
// });

Route::post('/login', function (Request $request) {
    // 유효성 검사
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // 사용자
    $user = User::where('email', $request->email)->first();

    // 사용자 인증
    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    } else {
        // 사용자에게 토큰 발급
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
});