<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pkg_OrderDesMissions\MissionsController;

Route::prefix('OrderDesMissions')->group(function () {
    Route::get('/missions/moreDetails/{mission}', [MissionsController::class, 'moreDetails'])->name('missions.moreDetails');
    Route::post('/missions/import', [MissionsController::class, 'import'])->name('missions.import');
    Route::get('/missions/export', [MissionsController::class, 'export'])->name('missions.export');
    Route::resource('missions', MissionsController::class);
});