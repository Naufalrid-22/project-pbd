<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarginPenjualanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;

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


