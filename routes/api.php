<?php

use App\Http\Controllers\Api\UserController;
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
    // dd($request);
    return $request->user();
});

// public routes
Route::controller(UserController::class)->prefix("users")->group(function () {
    Route::post("login",  'login')->name('login');
    Route::post('register', 'register');
});

// protectted routes
Route::controller(UserController::class)->prefix("users")->middleware('auth:sanctum')->group(function () {
    // protectted routes
    Route::get("/",  'index');
    Route::get("/{id}",  'show');
    Route::post("/",  'store');
    Route::put("/{id}",  'update');
    Route::patch("/{id}",  'update');
    Route::delete('logout',  'logout');
    Route::delete('/{id}',  'destroy');
});

// Route::apiResource("users", UserController::class);
