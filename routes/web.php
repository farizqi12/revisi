<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManageUser;
use App\Http\Controllers\Topup;
use App\Http\Controllers\KelolaTransaksi;

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

    Route::get('/kelola-transaksi', [KelolaTransaksi::class, 'show'])->name('kelola.transaksi');
     Route::get('/transaksi/filter', [KelolaTransaksi::class, 'filter'])->name('admin.transaksi.filter');
    Route::post('/transaksi/{id}/update', [KelolaTransaksi::class, 'updateStatus'])->name('admin.transaksi.update');
});

Route::middleware(['auth', 'only.guru'])->group(function () {
    Route::get("/dashboard-guru", [LoginController::class, "dashboardGuru"])->name("dashboard.guru");

    Route::get('/topup', [Topup::class, 'show'])->name('topup');
    Route::post('/topup-store', [Topup::class, 'store'])->name('topup.store');
    Route::get('/topup-penarikan', [Topup::class, 'showPenarikan'])->name('topup.penarikan');
    Route::post('/withdraw-store', [Topup::class, 'withdraw'])->name('withdrawal.store');
    Route::get('/riwayat-topup', [Topup::class, 'showriwayat'])->name('riwayat.topup');


});
