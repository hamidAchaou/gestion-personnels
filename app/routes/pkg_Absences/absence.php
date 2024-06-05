<?php

use App\Http\Controllers\pkg_Absences\AbsenceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('absence')->middleware(['auth'])->group(function () {
    // Route::resource('/', AbsenceController::class);
    Route::get('/export', [AbsenceController::class, 'export'])->name('absence.export');
    Route::post('/import', [AbsenceController::class, 'import'])->name('absence.import');

    Route::get('/', [AbsenceController::class, 'index'])->name("absence.index");
    Route::get('/create', [AbsenceController::class, 'create'])->name("absence.create");
    Route::post('/create', [AbsenceController::class, 'store'])->name("absence.store");
    Route::get('/{matricule}', [AbsenceController::class, 'show'])->name("absence.show");
    Route::delete('/{id}', [AbsenceController::class, 'destroy'])->name("absence.destroy");
    Route::get('/edit/{absence}', [AbsenceController::class, 'edit'])->name("absence.edit");
    Route::put('/edit/{absence}', [AbsenceController::class, 'update'])->name("absence.update");

});

