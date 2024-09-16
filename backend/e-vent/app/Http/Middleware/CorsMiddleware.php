<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $allowedOrigins = [
            'http://localhost:5173',
            
        ];

        $origin = $request->header('Origin');

        if (in_array($origin, $allowedOrigins)) {
            $headers = [
                'Access-Control-Allow-Origin' => $origin,
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Headers' => $request->header('Access-Control-Request-Headers'),
            ];

            if ($request->isMethod('OPTIONS')) {
                return response('', 200)->withHeaders($headers);
            }

            $response = $next($request);

            foreach ($headers as $key => $value) {
                $response->headers->set($key, $value);
            }

            return $response;
        }

        return $next($request);
    }

}
