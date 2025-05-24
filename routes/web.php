<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManageUser;
use App\Http\Controllers\Topup;

Route::get("/", [App\Http\Controllers\LoginController::class, "showLoginForm"])->name("login");
Route::post("/login", [App\Http\Controllers\LoginController::class, "login"])->name("login.post");
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'only.kepala.sekolah'])->group(function () {
    Route::get("/dashboard", [LoginController::class, "dashboard"])->name("dashboard.kepala");
    Route::get("/user-manage", [ManageUser::class, "show"])->name("userManage");
    Route::post('/users/create', [ManageUser::class, 'create'])->name('users.create');
    Route::post('/users/update', [ManageUser::class, 'update'])->name('users.update');
    Route::post('/users/delete', [ManageUser::class, 'delete'])->name('users.delete');
    Route::get('/users/search', [ManageUser::class, 'search'])->name('users.search');
    Route::get('/users', [ManageUser::class, 'index'])->name('users.index');
});

Route::middleware(['auth', 'only.guru'])->group(function () {
    Route::get("/dashboard-guru", [LoginController::class, "dashboardGuru"])->name("dashboard.guru");

    Route::get('/topup', [Topup::class, 'show'])->name('topup');
});
