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

    public function redirectToEtablissement()
    {
        $etablissement = Etablissement::pluck('nom')->first();

        // Check if an establishment was found
        if ($etablissement) {
            return redirect()->route('etablissement.app', ['etablissement' => $etablissement]);
        }

        // Handle the case where no establishment is found
        return redirect()->route('some.other.route'); // replace 'some.other.route' with a valid route
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
