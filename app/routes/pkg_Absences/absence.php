<?php

use App\Http\Controllers\pkg_Absences\AbsenceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('{etablissement}/absence')->middleware(['auth', 'authorize.etablissement'])->group(function () {
    // Route::resource('/', AbsenceController::class);
    Route::get('/export', [AbsenceController::class, 'export'])->name('absence.export');
    Route::post('/import', [AbsenceController::class, 'import'])->name('absence.import');

    Route::get('/filter-by-motif', [AbsenceController::class, 'filterByMotif'])->name('absence.filterByMotif');
    Route::get('/filter-by-date', [AbsenceController::class, 'filterByDate'])->name('absence.filterByDate');
    Route::get('/document-absenteisme', [AbsenceController::class, 'document_absenteisme'])->name('absence.document_absenteisme');

    Route::get('/filter-and-print', [AbsenceController::class, 'filterAndPrint'])->name('absence.filterAndPrint');

    Route::get('/', [AbsenceController::class, 'index'])->name("absence.index");
    Route::get('/create', [AbsenceController::class, 'create'])->name("absence.create");
    Route::post('/create', [AbsenceController::class, 'store'])->name("absence.store");
    Route::get('/{matricule}', [AbsenceController::class, 'show'])->name("absence.show")->where('matricule', '[0-9]+');
    Route::delete('/{id}', [AbsenceController::class, 'destroy'])->name("absence.destroy")->where('id', '[0-9]+');
    Route::get('/edit/{absence}', [AbsenceController::class, 'edit'])->name("absence.edit")->where('absence', '[0-9]+');
    Route::put('/edit/{absence}', [AbsenceController::class, 'update'])->name("absence.update")->where('absence', '[0-9]+');
});


