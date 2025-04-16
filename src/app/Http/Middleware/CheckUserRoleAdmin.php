<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleAdmin
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->role == 'ADMIN') {
            return $next($request);
        }

        abort(403, 'Você não tem permissão para acessar este recurso.');
    }
}
