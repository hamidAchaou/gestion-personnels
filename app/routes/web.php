<?php

use App\Models\pkg_Parametres\Etablissement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    $etablissement = Etablissement::pluck('nom')->first();
    return redirect()->route('etablissement.app', $etablissement);
})->middleware('auth')->name('home');

Auth::routes();

Route::get('/{etablissement}/app', [App\Http\Controllers\HomeController::class, 'index'])->name('etablissement.app');


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
