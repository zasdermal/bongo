<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// function getModuleRoutes(): array
// {
//     $routes = [];

//     foreach (glob(__DIR__ . '/../module/*/routes.php') as $routeFile) {
//         $routes[] = $routeFile;
//     }

//     return $routes;
// }

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: getModuleRoutes()
        web: __DIR__ . '/../module/web.php',
        api: __DIR__.'/../module/api.php',
        // health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
