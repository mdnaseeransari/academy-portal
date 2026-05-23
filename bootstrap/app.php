<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\NoCacheHeaders::class,
        ]);

        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 419 TokenMismatchException (session expired / CSRF token mismatch)
        $exceptions->render(function (Illuminate\Session\TokenMismatchException $e, Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your session has expired. Please refresh the page and try again.',
                    'error' => 'token_mismatch'
                ], 419);
            }

            // If user is authenticated, redirect back to previous page
            if (auth()->check()) {
                return back()
                    ->withInput()
                    ->with('error', 'Your session has expired. Please try again.');
            }

            // If user is guest (on login page), redirect to login with message
            return redirect()
                ->route('login')
                ->with('error', 'Your session has expired. Please login again.');
        });
    })->create();
