<?php

namespace App\Http\Middleware;

use Closure;

class StudentAffairAdmin
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
        $admin=auth()->user()->role;
        return $admin==3||$admin==1?$next($request):response(view('errors.401'),401);
    }
}
