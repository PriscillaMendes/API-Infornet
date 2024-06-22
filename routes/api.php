<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Middleware\Api\V1\ProtectedRouteAuth;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::prefix("v1")->group(function () {
    
    Route::get("/", [UserController::class, 'index'])->name('users.index');
    
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/me', [AuthController::class, 'me'])->middleware(ProtectedRouteAuth::class);

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}', [UserController::class, 'show'])->name('users.show');

});
