<?php
use App\Http\Controllers\pkg_Conges\CongesController;
use Illuminate\Support\Facades\Route;

Route::prefix('{etablissement}/conges')->middleware(['auth'])->group(function () {    
    // Routes for managing Conges
    Route::get('/', [CongesController::class, 'index'])->name('conges.index');
    Route::get('/create', [CongesController::class, 'create'])->name('conges.create');
    Route::post('/store', [CongesController::class, 'store'])->name('conges.store');
    Route::get('/{conge}', [CongesController::class, 'show'])->name('conges.show');
    
    Route::get('/{conge}/edit', [CongesController::class, 'edit'])->name('conges.edit');
    Route::put('/{conge}', [CongesController::class, 'update'])->name('conges.update');
    Route::delete('/{conge}', [CongesController::class, 'destroy'])->name('conges.destroy');

    Route::get('/{conge}/decision', [CongesController::class, 'decision'])->name('conges.decision');
    Route::get('/export', [CongesController::class, 'export'])->name('conges.export');
    Route::post('/import', [CongesController::class, 'import'])->name('conges.import');
});
