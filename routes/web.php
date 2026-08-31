<?php

use App\Http\Controllers\DataTableController;
use App\Http\Controllers\FieldDataProviderController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('api/data-tables/{table}', DataTableController::class)->name('data-tables.show');
    Route::get('api/field-data/{provider}', FieldDataProviderController::class)->name('field-data.show');
});

require __DIR__.'/settings.php';
