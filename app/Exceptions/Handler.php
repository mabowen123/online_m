<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        if ($exception instanceof ValidationException) {
            $errors = $exception->errors();
            $message = '表单验证未通过';
            foreach ($errors as $key => $value) {
                if (is_array($value)) {
                    $message = $value[0];
                } elseif (is_string($value)) {
                    $message = $value;
                }

                break;
            }
            return failed($message, Response::HTTP_UNPROCESSABLE_ENTITY, $errors);
        } elseif ($exception instanceof UserNotDefinedException) {
            return failed('登录信息已失效', Response::HTTP_UNAUTHORIZED);
        } elseif ($exception instanceof AuthenticationException) {
            return failedWithStatusCode('登录信息已失效', Response::HTTP_UNAUTHORIZED);
        } elseif ($exception instanceof NotFoundHttpException) {
            return failedWithStatusCode('请求地址不存在', Response::HTTP_NOT_FOUND);
        } else {
            return failed($exception->getMessage(), intval($exception->getCode()));
        }
    }
}
