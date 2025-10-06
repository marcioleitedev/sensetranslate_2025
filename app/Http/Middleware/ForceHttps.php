<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar se é HTTPS através de headers do proxy/load balancer
        $isHttps = $request->secure() || 
                   $request->header('x-forwarded-proto') === 'https' ||
                   $request->header('x-forwarded-ssl') === 'on' ||
                   $request->header('cf-visitor') === '{"scheme":"https"}'; // Cloudflare

        if ($isHttps) {
            URL::forceScheme('https');
        }

        return $next($request);
    }
}