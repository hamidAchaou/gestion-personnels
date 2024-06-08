<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthorizeEtablissement
{
    public function handle($request, Closure $next)
    {
        $etablissement = $request->route('etablissement');
        $user = Auth::user();
        $roles = $user->getRoleNames()->toArray();
        
        if (!in_array('admin', $roles) && $user->etablissement->nom !== $etablissement) {
            abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }
}
