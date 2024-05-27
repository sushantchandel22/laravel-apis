<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;
class Handler extends Exception
{
    public function render($request, Throwable $exception)
    {
        dd($exception);
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['error' => 'Method not allowed.'], 405);
        }   
        return false;
    }
}
