<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManageUser;
use App\Http\Controllers\Topup;
use App\Http\Controllers\KelolaTransaksi;
use App\Http\Controllers\AturAbsen;
use App\Http\Controllers\Profil;

use App\Http\Controllers\SitemapController;

Route::get('/sitemap.xml', [SitemapController::class, 'generate']);

Route::get('/', [App\Http\Controllers\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'only.kepala.sekolah'])->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard.kepala');

    Route::get('/user-manage', [ManageUser::class, 'show'])->name('userManage');
    Route::post('/users/create', [ManageUser::class, 'create'])->name('users.create');
    Route::post('/users/update', [ManageUser::class, 'update'])->name('users.update');
    Route::post('/users/delete', [ManageUser::class, 'delete'])->name('users.delete');
    Route::get('/users/search', [ManageUser::class, 'search'])->name('users.search');
    Route::get('/users', [ManageUser::class, 'index'])->name('users.index');
    Route::get('/export-user', [ManageUser::class, 'export'])->name('users.export');


    Route::get('/kelola-transaksi', [KelolaTransaksi::class, 'show'])->name('kelola.transaksi');
    Route::get('/transaksi/filter', [KelolaTransaksi::class, 'filter'])->name('admin.transaksi.filter');
    Route::post('/transaksi/{id}/update', [KelolaTransaksi::class, 'updateStatus'])->name('admin.transaksi.update');

    Route::get('/atur-absen', [AturAbsen::class, 'show'])->name('atur.absen');
    Route::post('/atur-absen', [AturAbsen::class, 'store'])->name('lokasi.store');
    Route::get('/atur-absen/{id}/edit', [AturAbsen::class, 'edit'])->name('lokasi.edit');
    Route::put('/atur-absen/{id}', [AturAbsen::class, 'update'])->name('atur.absen.update');
    Route::delete('/atur-absen/{id}', [AturAbsen::class, 'destroy'])->name('lokasi.destroy');
    Route::get('/search', [AturAbsen::class, 'searchLocation'])->name('lokasi.search');
    Route::get('/reverse-geocode', [AturAbsen::class, 'reverseGeocode'])->name('lokasi.reverse');

    Route::get('/transaksi/{id}/invoice', [KelolaTransaksi::class, 'showInvoice'])->name('transaksi.invoice');

    Route::get('/pantau-absen', [App\Http\Controllers\PantauAbsen::class, 'show'])->name('pantau.absen');
    Route::get('/pantau-absen-now', [App\Http\Controllers\PantauAbsen::class, 'showNow'])->name('pantau.absen.now');
    Route::get('/pantau-absen-sort', [App\Http\Controllers\PantauAbsen::class, 'showSort'])->name('pantau.absen.sort');
    Route::get('/pantau-absen-export', [App\Http\Controllers\PantauAbsen::class, 'export'])->name('pantau.absen.export');


    Route::get('/riwayat-absensi-id/{id}', [App\Http\Controllers\ManageUser::class, 'showid'])->name('riwayat.absen.id');

});

Route::middleware(['auth', 'only.guru'])->group(function () {
    Route::get('/dashboard-guru', [LoginController::class, 'dashboardGuru'])->name('dashboard.guru');

    Route::get('/topup', [Topup::class, 'show'])->name('topup');
    Route::post('/topup-store', [Topup::class, 'store'])->name('topup.store');
    Route::get('/topup-penarikan', [Topup::class, 'showPenarikan'])->name('topup.penarikan');
    Route::post('/withdraw-store', [Topup::class, 'withdraw'])->name('withdrawal.store');
    Route::get('/riwayat-topup', [Topup::class, 'showriwayat'])->name('riwayat.topup');

    Route::get('/profil', [Profil::class, 'show'])->name('profil.show');

    route::get('/absensi', [App\Http\Controllers\Absen::class, 'show'])->name('absensi.show');
    route::get('/absensi-izin', [App\Http\Controllers\Absen::class, 'showIzin'])->name('absensi.show.izin');
    route::get('/absensipulang', [App\Http\Controllers\Absen::class, 'showpulang'])->name('absensipulang.show');

    Route::post('/absen', [App\Http\Controllers\Absen::class, 'store'])->name('absen.store');
    Route::post('/absenpulang', [App\Http\Controllers\Absen::class, 'storePulang'])->name('absen.storePulang');
    Route::post('/absenizin', [App\Http\Controllers\Absen::class, 'storeIzin'])->name('absen.izin.store');

    Route::get('/riwayat-absensi', [App\Http\Controllers\RiwayatAbsen::class, 'show'])->name('riwayat.absen');
    Route::get('/riwayat-absen-now', [App\Http\Controllers\RiwayatAbsen::class, 'showNow'])->name('riwayat.absen.now');
    Route::get('/riwayat-absen-sort', [App\Http\Controllers\RiwayatAbsen::class, 'showSort'])->name('riwayat.absen.sort');
    Route::get('/riwayat-absen-export', [App\Http\Controllers\RiwayatAbsen::class, 'export'])->name('riwayat.absen.export');
});
