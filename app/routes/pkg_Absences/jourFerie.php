<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pkg_Absences\JourFerieController;


Route::prefix('{etablissement}/jourFerie')->middleware(['auth', 'authorize.etablissement'])->group(function () {

    Route::get('/export', [JourFerieController::class, 'export'])->name('jourFerie.export');
    Route::post('/import', [JourFerieController::class, 'import'])->name('jourFerie.import');

    Route::get('/', [JourFerieController::class, 'index'])->name('jourFerie.index');
    Route::get('/create', [JourFerieController::class, 'create'])->name('jourFerie.create');
    Route::post('/create', [JourFerieController::class, 'store'])->name('jourFerie.store');
    Route::get('/edit/{jourFerie}', [JourFerieController::class, 'edit'])->name('jourFerie.edit');
    Route::put('/edit/{jourFerie}', [JourFerieController::class, 'update'])->name('jourFerie.update');
    Route::delete('/{jourFerie}', [JourFerieController::class, 'destroy'])->name('jourFerie.destroy');

});
