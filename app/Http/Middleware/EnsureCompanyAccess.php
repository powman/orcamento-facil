<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->company_id) {
            abort(403, 'Acesso não autorizado. Sua conta não está vinculada a uma empresa.');
        }

        return $next($request);
    }
}
