<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user->role == 'ADMIN' || $user->role == 'MODERATOR') {
            return $next($request);
        }

        abort(403, 'Você não tem permissão para acessar este recurso.');
    }
}
