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
            // Abaikan error validasi dan 404 agar log tidak penuh sampah
            if ($e instanceof \Illuminate\Validation\ValidationException ||
                $e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                return;
            }

            try {
                \App\Models\AuditLog::create([
                    'user_id' => Auth::id(), // Gunakan Auth::id() lebih aman
                    'action' => 'ERROR',
                    // Masukkan detail teknis ke dalam description karena kolom payload tidak ada
                    'description' => 'System Crash: '.$e->getMessage().' | File: '.$e->getFile().' L:'.$e->getLine(),
                    'model' => 'System',
                    'model_id' => 0,
                    'ip_address' => request()->ip(),
                ]);
            } catch (\Exception $fallback) {
                // Jika DB down, Laravel log otomatis ke file storage/logs
            }
        });
    })->create();
