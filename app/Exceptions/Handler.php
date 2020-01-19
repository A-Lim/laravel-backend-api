<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
        if (request()->wantsJson()) {
            // get class of exception
            $class = get_class($exception);
            $headers = ['Content-Type', 'application/json'];
            
            // override exceptions
            // sends out custom response output
            switch ($class) {
                case 'Laravel\Passport\Exceptions\OAuthServerException':
                    return response()->json(['message' => $exception->getMessage()], 401, $headers);
                    break;
                
                case 'Illuminate\Database\Eloquent\ModelNotFoundException':
                    $model_name = last(explode('\\', $exception->getModel()));
                    return response()->json(['message' => 'Resource '.strtolower($model_name).' not found.'], 404, $headers);
                    break;
                
                case 'Illuminate\Auth\Access\AuthorizationException':
                    return response()->json(['message' => 'You do not have permission to perform this action.'], 403, $headers);
                    break;

                case 'Illuminate\Routing\Exceptions\InvalidSignatureException':
                    return response()->json(['message' => 'Invalid signature.'], 403, $headers);
                    break;
            }
        }
        
        return parent::render($request, $exception);
    }
}
