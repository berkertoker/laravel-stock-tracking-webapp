<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Manager\DeleteTemporaryImageController;
use App\Http\Controllers\Manager\ImageController;
use App\Http\Controllers\Manager\ProductController;
use App\Http\Controllers\Manager\UploadTemporaryImageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified', 'admin')->group(function () {
    Route::resource('admindashboard', AdminController::class);
});

Route::middleware('auth', 'verified', 'manager')->group(function () {
    Route::resource('products', ProductController::class);
    Route::post('/upload', UploadTemporaryImageController::class);
    Route::delete('/revert/{uniqueId}', DeleteTemporaryImageController::class);
    Route::delete('/product/{id}', ImageController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
