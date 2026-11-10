
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Pengecualian CSRF untuk endpoint SOAP
        $middleware->validateCsrfTokens(except: [
            'soap/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Memastikan respons API menggunakan JSON
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request, Throwable $e) =>
                $request->is('api/*') || $request->expectsJson()
        );

        // HTTP 401 - Unauthorized
        $exceptions->render(function (
            AuthenticationException $e,
            Request $request
        ) {
            if ($request->is('api/*')) {
                return response()->json([
                    'type' => 'about:blank',
                    'title' => 'Unauthorized',
                    'status' => 401,
                    'detail' => 'Autentikasi diperlukan.',
                    'instance' => $request->getRequestUri(),
                ], 401, [
                    'Content-Type' => 'application/problem+json',
                ]);
            }
        });

        // HTTP 404 - Not Found
        $exceptions->render(function (
            NotFoundHttpException $e,
            Request $request
        ) {
            if ($request->is('api/*')) {
                return response()->json([
                    'type' => 'about:blank',
                    'title' => 'Not Found',
                    'status' => 404,
                    'detail' => 'Resource tidak ditemukan.',
                    'instance' => $request->getRequestUri(),
                ], 404, [
                    'Content-Type' => 'application/problem+json',
                ]);
            }
        });

        // HTTP 422 - Validation Error
        $exceptions->render(function (
            ValidationException $e,
            Request $request
        ) {
            if ($request->is('api/*')) {
                return response()->json([
                    'type' => 'about:blank',
                    'title' => 'Unprocessable Entity',
                    'status' => 422,
                    'detail' => 'Data yang dikirim tidak valid.',
                    'instance' => $request->getRequestUri(),
                    'errors' => $e->errors(),
                ], 422, [
                    'Content-Type' => 'application/problem+json',
                ]);
            }
        });

    })->create();
