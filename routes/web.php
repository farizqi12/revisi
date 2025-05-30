<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManageUser;
use App\Http\Controllers\Topup;
use App\Http\Controllers\KelolaTransaksi;
use App\Http\Controllers\AturAbsen;
use App\Http\Controllers\Profil;

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

    Route::get('/atur-absen', [AturAbsen::class, 'show'])->name('atur.absen');
    Route::post('/atur-absen', [AturAbsen::class, 'store'])->name('lokasi.store');
    Route::get('/atur-absen/{id}/edit', [AturAbsen::class, 'edit'])->name('lokasi.edit');
    Route::put('/atur-absen/{id}', [AturAbsen::class, 'update'])->name('lokasi.update');
    Route::delete('/atur-absen/{id}', [AturAbsen::class, 'destroy'])->name('lokasi.destroy');
    Route::get('/search', [AturAbsen::class, 'searchLocation'])->name('lokasi.search');
    Route::get('/reverse-geocode', [AturAbsen::class, 'reverseGeocode'])->name('lokasi.reverse');

    Route::get('/transaksi/{id}/invoice', [KelolaTransaksi::class, 'showInvoice'])->name('transaksi.invoice');
});

Route::middleware(['auth', 'only.guru'])->group(function () {
    Route::get("/dashboard-guru", [LoginController::class, "dashboardGuru"])->name("dashboard.guru");

    Route::get('/topup', [Topup::class, 'show'])->name('topup');
    Route::post('/topup-store', [Topup::class, 'store'])->name('topup.store');
    Route::get('/topup-penarikan', [Topup::class, 'showPenarikan'])->name('topup.penarikan');
    Route::post('/withdraw-store', [Topup::class, 'withdraw'])->name('withdrawal.store');
    Route::get('/riwayat-topup', [Topup::class, 'showriwayat'])->name('riwayat.topup');

    Route::get('/profil', [Profil::class, 'show'])->name('profil.show');
});
