<?php
namespace App\Exceptions;

use Throwable;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Exceptions\UnauthorizedException;

use App\Traits\ApiResponse;

class Handler extends ExceptionHandler
{
    use ApiResponse;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof Responsable) {
            return $exception->toResponse($request);
        }

        $exception = $this->prepareException($exception);

        if ($exception instanceof HttpResponseException) {
            return $this->errorResponse($exception->getResponse(), 500);
        } elseif ($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        } elseif ($exception instanceof ModelNotFoundException) {
            $modelo = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse(trans('errors.there_is_no_instance_of_with_the_specified_id', ['name' => $modelo]), 404);
        } elseif ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        } elseif ($exception instanceof AuthorizationException || $exception instanceof UnauthorizedException || $exception instanceof PermissionDoesNotExist) {
            return $this->errorResponse(trans('errors.you_do_not_have_permissions_to_execute_this_action'), 403);
        } elseif ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse(trans('errors.the_specified_url_was_not_found'), 404);
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse(trans('errors.errors.the_method_specified_in_the_request_is_invalid'), 405);
        } elseif ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        } elseif ($exception instanceof QueryException) {
            $codigo = $exception->errorInfo[1];

            if ($codigo == 1451) {
                return $this->errorResponse(trans('errors.the_resource_cannot_be_permanently_deleted_because_it_is_related_to_some_other'), 409);
            }

            return $this->errorResponse($exception->getMessage(), 409);
        }

        if (!config('app.debug')) {
            return $this->errorResponse(trans('errors.unexpected_failure_try_later'), 500);
        }

        return $this->prepareJsonResponse($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->responseJson(['message' => $exception->getMessage()], 401);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return $this->invalidJson($request, $e);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return $this->responseJson([
            'message' => trans('errors.the_given_data_was_invalid'),
            'errors' => $exception->errors(),
        ], $exception->status);
    }

    protected function responseJson($data, $status = 200)
    {
        Log::debug('[responseJson] Status: ' . $status . ' data: ' . json_encode($data));
        return response()->json($data, $status);
    }
}
