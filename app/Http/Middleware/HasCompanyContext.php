<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class HasCompanyContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // perform check, make sure the user belongs to a company
        if (session()->has('çompany_id')) {
            return $next($request);
        }

        session()->flash('error', 'Please select a company first.');
        return redirect(URL::previous());
    }
}
