<?php

namespace App\Http\Controllers;

use App\Models\pkg_Parametres\Etablissement;
use App\Models\pkg_PriseDeServices\Personnel;
use App\Repositories\pkg_Conges\CongesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $roles = $user->getRoleNames();

        if ($roles !== 'admin') {
            $etablissement = Auth::user()->etablissement->nom;
        } else {
            $etablissement = Etablissement::pluck('nom')->first();
        }

        return redirect()->route('etablissement.app', ['etablissement' => $etablissement]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(CongesRepository $congesRepository, $etablissement)
    {
        $conges = $congesRepository->getCongesForCurrentDate($etablissement);
        $congesActual = $conges->total();
        $etablissement = Etablissement::where('nom', $etablissement)->firstOrFail();
        return view('home', compact('etablissement', 'congesActual'));
    }
}
