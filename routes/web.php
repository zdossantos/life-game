<?php

use App\Http\Controllers\SaveController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/', [saveController::class, 'store'])->name('save.store');
});

Route::get('dashboard', function () {
    return SaveController::userSaves();
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('/{id?}', function ($id = null) {
    return SaveController::show($id);
})->name('home');
