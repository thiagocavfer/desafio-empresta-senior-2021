<?php

namespace App\Exceptions;

use Error;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use ReflectionException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        /*$this->reportable(function (Throwable $e) {
            //
        });*/

        $erro500 = [
            'errorMsg' => 'Erro interno da aplicação.',
        ];

        $erro404 =            [
            'errorMsg' => 'Endpoint não encontrado.',
        ];

        $this->renderable(function (NotFoundHttpException $e, $request) use ($erro404) {
            return  response()->json($erro404, 404);
        });

        $this->renderable(function (ReflectionException $e, $request) use ($erro500) {
            return  response()->json($erro500, 500);
        });

        $this->renderable(function (Error $e, $request) use ($erro500) {
            return  response()->json($erro500, 500);
        });

        $this->renderable(function (BindingResolutionException $e, $request) use ($erro500) {
            return  response()->json($erro500, 500);
        });
    }
}
