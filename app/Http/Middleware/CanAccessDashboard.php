<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;

class CanAccessDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        if (Auth::check() && ($user && $user->isOwner() || $user->isEmployee())) {
            return $next($request);
        }

        return redirect('/');
    }
}
