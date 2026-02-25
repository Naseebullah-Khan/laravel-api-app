<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get(uri: "/user", action: function (): mixed {
    return request()->user();
})->middleware(middleware: "auth:sanctum");

Route::apiResource(name: "posts",  controller: PostController::class);

Route::post(uri: '/register', action: [AuthController::class, "register"])->name(name: "auth.register");
Route::post(uri: '/login', action: [AuthController::class, "login"])->name(name: "auth.login");
Route::post(uri: '/logout', action: [AuthController::class, "logout"])->name(name: "auth.logout")->middleware(middleware: "auth:sanctum");
