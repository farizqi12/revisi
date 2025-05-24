<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get("/", [App\Http\Controllers\LoginController::class, "showLoginForm"])->name("login");
Route::post("/login", [App\Http\Controllers\LoginController::class, "login"])->name("login.post");
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'only.kepala.sekolah'])->group(function () {
    Route::get("/dashboard", [LoginController::class, "dashboard"])->name("dashboard.kepala");
});

Route::middleware(['auth', 'only.guru'])->group(function () {
    Route::get("/dashboard-guru", [LoginController::class, "dashboardGuru"])->name("dashboard.guru");
});