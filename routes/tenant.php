<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return 'Ini Halaman Dashboard Tenant';
})->name('dashboard');
