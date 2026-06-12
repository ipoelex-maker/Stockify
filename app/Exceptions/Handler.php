<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Tangkap error Spatie "tidak punya role" → redirect ke dashboard
    | dengan pesan error yang user-friendly
    |--------------------------------------------------------------------------
    */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedException) {
            return redirect()->route('dashboard')
                ->with('error', '🚫 Kamu tidak punya akses ke halaman tersebut.');
        }

        return parent::render($request, $exception);
    }
}