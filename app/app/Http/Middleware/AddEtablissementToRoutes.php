<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class AddEtablissementToRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get the 'etablissement' parameter from the route
        $etablissement = $request->route('etablissement');

        // If 'etablissement' parameter exists, set it as a default parameter for URL generation
        if ($etablissement) {
            URL::defaults(['etablissement' => $etablissement]);
        }

        return $next($request);
    }
}