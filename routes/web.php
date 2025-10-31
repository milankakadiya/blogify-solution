<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\PublicPostController;

// Public routes
Route::get('/', [PublicPostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PublicPostController::class, 'show'])->name('posts.show');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('posts', PostController::class);

    Route::get('imports', [ImportController::class, 'index'])->name('imports.index');
    Route::post('imports', [ImportController::class, 'import'])->name('imports.import');
});
