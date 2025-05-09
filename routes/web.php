<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/run-migrations', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations completed!';
});
