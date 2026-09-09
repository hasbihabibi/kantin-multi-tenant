<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return 'Ini Halaman Katalog Customer';
})->name('dashboard');
