<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
        $this->renderable(function (NotFoundHttpException $e) {
            return $this->getResponse('Not Found', $e->getStatusCode());
        });

        $this->renderable(function (AccessDeniedHttpException $e) {
            return $this->getResponse($e->getMessage(), $e->getStatusCode());
        });

        $this->renderable(function (HttpException $e) {
            $message = $e->getMessage();

            if (!$message) {
                switch ($e->getStatusCode()) {
                    case 401:
                        $message = 'Unauthorized.';
                        break;
                    case 403:
                        $message = 'Forbidden.';
                        break;
                    default:
                        $message = 'Internal Server Error.';
                }
            }

            return $this->getResponse($message, $e->getStatusCode());
        });
    }

    private function getResponse($message, $status)
    {
        return response()
            ->json(['message' => $message], $status);
    }
}
