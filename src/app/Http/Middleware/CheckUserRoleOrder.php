<?php

namespace App\Http\Middleware;

use App\Http\Repositories\OrderRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRoleOrder extends OrderRepository
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user->role == 'ADMIN') {
            return $next($request);
        }

        $id = $request->route('id');
        $order = $this->findOrderById($id);

        if($order->user_id == Auth::id()){
            return $next($request);
        }

        abort(403, 'Você não tem permissão para acessar este recurso.');
    }
}
