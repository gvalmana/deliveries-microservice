<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class CheckAuthorizationHeader
{
    public function handle($request, Closure $next)
    {
        // Verificar si el encabezado Authorization está presente
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $authorizationHeader = $request->header('Authorization');
        $secretPhrase = Config::get('globals.security_key');

        // Verificar si el encabezado Authorization comienza con 'Bearer '
        if (!Str::startsWith($authorizationHeader, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Obtener el token sin el prefijo 'Bearer '
        $token = Str::substr($authorizationHeader, 7);

        // Verificar si el token coincide con la frase secreta
        if ($token !== $secretPhrase) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
