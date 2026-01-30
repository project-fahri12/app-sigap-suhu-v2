<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->reportable(function (Throwable $e) {
            if ($e instanceof \Illuminate\Validation\ValidationException ||
                $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return;
            }

            // Catat ke Database
            try {
                \App\Models\AuditLog::create([
                    'user_id' => Auth::user() ?? null,
                    'action' => 'ERROR',
                    'description' => 'System Crash: '.$e->getMessage(),
                    'ip_address' => request()->ip(),
                    'payload' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'url' => request()->fullUrl(),
                        'method' => request()->method(),
                        // 'trace' => substr($e->getTraceAsString(), 0, 500) // Opsional
                    ],
                ]);
            } catch (\Exception $fallback) {
                // Jika database juga error, biarkan Laravel mencatat ke file log standar saja
            }
        });
    })->create();
