<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\pkg_Parametres\Etablissement;

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
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $etablissement = Etablissement::where('nom', $etablissement)->firstOrFail();
        if (!$roles->contains(User::ADMIN)) {
            if ($user->etablissement_id !== $etablissement->id) {
                return abort(403);
            }
        }
        return view('home', compact('etablissement'));
    }
}
