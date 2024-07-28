<?php

use App\Http\Controllers\DataPaketController;
use App\Http\Controllers\PaketPenyediaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('penyedia')->name('penyedia.')->group(function () {
        Route::get('/data', [PaketPenyediaController::class, 'index'])->name('paket');

        Route::get('/paket', [PaketPenyediaController::class, 'ambilDataPenyedia'])
            ->name('paket')
            ->where('kldi', '[0-9]+')
            ->where('length', '[0-9]+');

        Route::get('/detail', [PaketPenyediaController::class, 'ambilDetailPenyedia'])
            ->name('detail')
            ->where('kldi', '[0-9]+')
            ->where('length', '[0-9]+');

        Route::get('/detail/{kode_rup}', [PaketPenyediaController::class, 'ambilDetailPenyediaSatuan'])
            ->name('detail.satuan')
            ->where('kode_rup', '[0-9]+');

        Route::get('/sumberdana', [PaketPenyediaController::class, 'ambilSumberDanaPenyedia'])
            ->name('sumberdana')
            ->where('kldi', '[0-9]+')
            ->where('length', '[0-9]+');

        Route::get('/sumberdana/{kode_rup}', [PaketPenyediaController::class, 'ambilSumberDanaPenyediaSatuan'])
            ->name('sumberdana.satuan')
            ->where('kode_rup', '[0-9]+');
    });

    //     Route::get('/paket/swakelola/ambil', [DataPaketController::class, 'dataSwakelola'])
    //         ->name('paket.swakelola.ambil')
    //         ->where('kldi', '[0-9]+')
    //         ->where('length', '[0-9]+');
});
