<?php
use App\Http\Controllers\pkg_Conges\CongesController;
use Illuminate\Support\Facades\Route;

Route::prefix('{etablissement}')->middleware(['auth'])->group(function () {    
    // Routes for managing Conges
    Route::get('/conges', [CongesController::class, 'index'])->name('conges.index');
    Route::get('/conges/create', [CongesController::class, 'create'])->name('conges.create');
    Route::post('/conges', [CongesController::class, 'store'])->name('conges.store');
    Route::get('/conges/{conge}', [CongesController::class, 'show'])->name('conges.show');
    Route::get('/conges/{conge}/edit', [CongesController::class, 'edit'])->name('conges.edit');
    Route::put('/conges/{conge}', [CongesController::class, 'update'])->name('conges.update');
    Route::delete('/conges/{conge}', [CongesController::class, 'destroy'])->name('conges.destroy');

    Route::get('/conges/{conge}/decision', [CongesController::class, 'decision'])->name('conges.decision');
    Route::get('/conges/personnesl/export', [CongesController::class, 'export'])->name('conges.export');
    Route::post('/conges/import', [CongesController::class, 'import'])->name('conges.import');
});
