<?php

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        /*
        $middleware->group('api', [
            \App\Http\Middleware\apiTokenApplication::class,
        ]);
        */
        $middleware->appendToGroup('api:jwt', [
            \App\Http\Middleware\apiProtectedRoute::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (UniqueConstraintViolationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Conflit in data, UniqueConstraintViolationException'
                ], 409);
            }
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 404);
            }
        });

        $exceptions->render(function (QueryException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 422);
            }
        });
    })
    ->withCommands([
        \App\Console\Commands\MigrateProductModule::class,
    ])
    ->create();
