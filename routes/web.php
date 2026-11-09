<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarginPenjualanController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PenjualanController;

Route::middleware('guest')
    ->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])
            ->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');

    Route::resource('barang', BarangController::class)
        ->except(['show']);

    Route::resource('satuan', SatuanController::class)
        ->except(['show']);

    Route::resource('vendor', VendorController::class)
        ->except(['show']);

    Route::resource('role', RoleController::class)
        ->except(['show']);

    Route::resource('user', UserController::class)
        ->except(['show']);

    Route::resource('margin_penjualan', MarginPenjualanController::class)
        ->except(['show']);

    Route::get('/pengadaan', [PengadaanController::class, 'index'])
    ->name('pengadaan.index');

    Route::get('/pengadaan/create', [PengadaanController::class, 'create'])
        ->name('pengadaan.create');

    Route::get('/pengadaan/{id}', [PengadaanController::class, 'show'])
        ->whereNumber('id')
        ->name('pengadaan.show');

    Route::post('/pengadaan', [PengadaanController::class, 'store'])
        ->name('pengadaan.store');

    Route::get('/penerimaan', [PenerimaanController::class, 'index'])
        ->name('penerimaan.index');

    Route::post('/penerimaan', [PenerimaanController::class, 'store'])
        ->name('penerimaan.store');
    });

Route::middleware(['auth', 'role:1,3'])->group(function () {

    Route::get('/penjualan', [PenjualanController::class, 'index'])
        ->name('penjualan.index');

    Route::get('/penjualan/create', [PenjualanController::class, 'create'])
        ->name('penjualan.create');

    Route::post('/penjualan', [PenjualanController::class, 'store'])
        ->name('penjualan.store');

    Route::get('/penjualan/{id}/detail', [PenjualanController::class, 'detail'])
        ->name('penjualan.detail');

});
