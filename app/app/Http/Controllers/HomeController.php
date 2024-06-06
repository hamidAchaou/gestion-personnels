<?php

namespace App\Http\Controllers;

use App\Models\pkg_Parametres\Etablissement;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($etablissement)
    {
        $etablissement = Etablissement::where('nom', $etablissement)->firstOrFail();

        return view('home', compact('etablissement'));
    }
}
