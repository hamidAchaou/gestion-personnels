<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pkg_Absences\JourFerieController;


Route::prefix('jourFerie')->middleware(['auth'])->group(function () {

    Route::get('/', [JourFerieController::class, 'index'])->name('jourFerie.index');

});