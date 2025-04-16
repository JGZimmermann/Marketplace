<?php

namespace App\Http\Middleware;

use App\Http\Repositories\AddressRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleAddress extends AddressRepository
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user->role == 'ADMIN') {
            return $next($request);
        }

        $id = $request->route('id');
        $address = $this->getAddressById($id);

        if($address->user_id == Auth::id()){
            return $next($request);
        }

        abort(403, 'Você não tem permissão para acessar este recurso.');
    }
}
