<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\pkg_Parametres\Etablissement;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', [HomeController::class, 'redirectToEtablissement'])->middleware('auth')->name('home');
Route::get('/', function () {
    $etablissement = Etablissement::pluck('nom')->first();
    return redirect()->route('etablissement.app', $etablissement);
})->middleware('auth')->name('home');

Auth::routes();

Route::get('/{etablissement}/app', [HomeController::class, 'index'])->name('etablissement.app');


