<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->company) {
            if (auth()->user()->company->status !== 'active') {
                auth()->logout();
                return redirect()->route('login')
                    ->withErrors('Your company is suspended.');
            }
        }

        return $next($request);
    }
}
