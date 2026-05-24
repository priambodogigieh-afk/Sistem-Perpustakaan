<?php

use App\Http\Controllers\LibraryController;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Support\Facades\Route;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

Route::withoutMiddleware([
    PreventRequestForgery::class,
    StartSession::class,
    ShareErrorsFromSession::class,
])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');

    Route::get('/laporan', [LibraryController::class, 'report'])->name('library.report');

    Route::get('/{section}', [LibraryController::class, 'index'])
        ->whereIn('section', ['katalog', 'anggota', 'sirkulasi', 'staf'])
        ->name('library.index');

    Route::post('/{section}', [LibraryController::class, 'store'])
        ->whereIn('section', ['katalog', 'anggota', 'sirkulasi', 'staf'])
        ->name('library.store');

    Route::put('/{section}/{id}', [LibraryController::class, 'update'])
        ->whereIn('section', ['katalog', 'anggota', 'sirkulasi', 'staf'])
        ->name('library.update');

    Route::delete('/{section}/{id}', [LibraryController::class, 'destroy'])
        ->whereIn('section', ['katalog', 'anggota', 'sirkulasi', 'staf'])
        ->name('library.destroy');
});
