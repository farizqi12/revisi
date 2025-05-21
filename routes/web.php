<?php

use Illuminate\Support\Facades\Route;

Route::get("/", [App\Http\Controllers\LoginController::class, "showLoginForm"])->name("login");
Route::post("/login", [App\Http\Controllers\LoginController::class, "login"])->name("login.post");
Route::get("/dashboard", [App\Http\Controllers\LoginController::class, "dashboard"])->name("dashboard")->middleware('only.kepala.sekolah');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('/user-manage', [App\Http\Controllers\ManageUser::class, 'show'])->name('usermanage');
