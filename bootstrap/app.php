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
    ->withMiddleware(function (Middleware $middleware) {
        //
         $middleware->web(append: [
            \RealRashid\SweetAlert\ToSweetAlert::class,
        ]);
        $middleware->alias([
            'Alert' => RealRashid\SweetAlert\Facades\Alert::class,
            'checkrole' => App\Http\Middleware\Checkrole::class,
            'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
