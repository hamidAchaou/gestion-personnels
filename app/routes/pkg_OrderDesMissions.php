<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pkg_OrderDesMissions\OrderDesMissionsController;



Route::prefix('Missions')->group(function () {
    Route::post('/mission/import', [OrderDesMissionsController::class, 'import'])->name('mission.import');
    Route::get('/mission/export', [OrderDesMissionsController::class, 'export'])->name('mission.export');
    Route::resource('mission', OrderDesMissionsController::class);
});