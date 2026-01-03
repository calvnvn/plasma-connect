<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\DeliveryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/farmers', [FarmerController::class, 'index'])->name('farmers.index');
    Route::get('/farmers/{farmer}', [FarmerController::class, 'show'])->name('farmers.show');
    Route::post('/farmers/{farmer}/deliveries', [DeliveryController::class, 'store'])->name('deliveries.store');
});

require __DIR__.'/auth.php';
