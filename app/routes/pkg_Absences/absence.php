<?php

use App\Http\Controllers\pkg_Absences\AbsenceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('absence')->middleware(['auth'])->group(function () {
    Route::resource('/', AbsenceController::class);
});

