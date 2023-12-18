<?php

namespace App\Exceptions;

use App\Traits\HasResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use PDOException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use HasResponse;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // return parent::render($request, $e);
        if ($e instanceof Responsable) {
            return $e->toResponse($request);
        }
        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        } elseif ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return $this->errorResponse(
                [],
                'Recurso no encontrado en el sistema.',
                JsonResponse::HTTP_NOT_FOUND
            );
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse(
                [],
                'Método no permitido en el sistema.',
                JsonResponse::HTTP_METHOD_NOT_ALLOWED
            );
        } elseif ($e instanceof AccessDeniedHttpException) {
            return $this->errorResponse(
                [],
                'Acceso denegado para realizar esta solicitud.',
                JsonResponse::HTTP_FORBIDDEN
            );
        } elseif ($e instanceof ValidationException) {
            return $this->errorResponse(
                $e->errors(),
                'Los datos proporcionados no son válidos.',
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            );
        } elseif ($e instanceof QueryException || $e instanceof PDOException) {
            $message = explode('(', $e->getMessage(), 2)[0];
            $errors = [];

            return $this->errorResponse(
                $errors,
                $message,
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->prepareJsonResponse($request, $e);
    }
}
