<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pkg_PriseDeServices\PersonnelController;
use App\Http\Controllers\pkg_PriseDeServices\AvancementController;

// Grouping routes that require authentication
Route::middleware(['auth'])->group(function () {
        Route::get('/personnels', [PersonnelController::class, 'index'])->name('personnels.index');
        Route::get('/personnels/create', [PersonnelController::class, 'create'])->name('personnels.create');
        Route::post('/personnels/store', [PersonnelController::class, 'store'])->name('personnels.store');
        Route::get('/personnels/{id}', [PersonnelController::class, 'show'])->name('personnels.show');
        Route::get('/personnels/{id}/edit', [PersonnelController::class, 'edit'])->name('personnels.edit');
        Route::put('/personnels/{id}/update', [PersonnelController::class, 'update'])->name('personnels.update');
        Route::delete('/personnels/{id}/destroy', [PersonnelController::class, 'destroy'])->name('personnels.destroy');
        Route::get('/personnels/attestation/{id}',[PersonnelController::class, 'attestation'])->name('personnels.attestation');

        Route::get('/personnel/export', [PersonnelController::class, 'export'])->name('personnels.export');
        Route::post('/personnels/import', [PersonnelController::class, 'import'])->name('personnels.import');

        // Category

        Route::get('/categories', [AvancementController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [AvancementController::class, 'create'])->name('categories.create');
        Route::post('/categories/store', [AvancementController::class, 'store'])->name('categories.store');
        Route::get('/categories/{id}', [AvancementController::class, 'show'])->name('categories.show');
        Route::get('/categories/{id}/edit', [AvancementController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{id}/update', [AvancementController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}/destroy', [AvancementController::class, 'destroy'])->name('categories.destroy');

        Route::get('/categories/export', [AvancementController::class, 'export'])->name('categories.export');
        Route::post('/categories/import', [AvancementController::class, 'import'])->name('categories.import');

});

Auth::routes(['register' => false]);
