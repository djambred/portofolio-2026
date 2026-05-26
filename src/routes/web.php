<?php

use App\Http\Controllers\CvController;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
Route::get('/', HomePage::class)->name('home');

Route::get('/cv', [CvController::class, 'show'])->name('cv.show');
Route::get('/cv/preview', [CvController::class, 'preview'])->name('cv.preview');
Route::get('/cv/download', [CvController::class, 'download'])->name('cv.download');
