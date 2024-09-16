<?php

use App\Http\Middleware\CorsMiddleware;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            '/all_articles',
            '/article',
            '/user/create_user',
            '/user/get_connected',
            '/user/update_profil',
            '/user/activate',
            '/user/change_mail',
            '/cart/add',
            '/cart/get',
            '/cart/get_qte_tot',
            '/cart/remove_article',
            '/cart/update_qte',
            '/cart/update_standby',
            '/stripe/pay',
            '/commande/get',
            
        ]);
        $middleware->append(CorsMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
