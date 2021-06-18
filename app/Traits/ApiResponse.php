<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait ApiResponse
{
    /**
     * Show json individual response
     * @param type $data
     * @return type
     */
    protected function createdResponse($data)
    {
        return $this->responseJson([
            'data' => $data
        ], 201);
    }

    /**
     * Show json individual response
     * @param type $data
     * @return type
     */
    protected function showResponse($data)
    {
        return $this->responseJson([
            'data' => $data,
        ]);
    }

    /**
     * List json individual response with paginate
     * @param type $data
     * @return type
     */
    protected function listResponse(Collection $data)
    {
        return $this->responseJson([
            'data'      => $data->all(),
            'paginator' => [
                'pages'        => (int) $data->lastPage(),
                'current_page' => (int) $data->currentPage(),
                'per_page'     => (int) $data->perPage(),
                'total'        => (int) $data->total(),
            ],
        ]);
    }

    /**
     * Not found response
     * @return type
     */
    protected function notFoundResponse()
    {
        return $this->responseJson([
            'data'    => 'Resource Not Found',
            'message' => 'Not Found'
        ], 404);
    }

    /**
     * Deleted response
     * @return type
     */
    protected function deletedResponse()
    {
        return $this->responseJson([
            'data'    => 'Resource deleted',
            'message' => 'Deleted'
        ]);
    }

    /**
     * Client error response
     * @param type $data
     * @return type
     */
    protected function clientErrorResponse($data)
    {
        return $this->responseJson([
            'data'    => $data,
            'message' => 'Unprocessable entity'
        ], 422);
    }

    /**
     * Client Unauthorized response
     * @param type $data
     * @return type
     */
    protected function clientUnauthorizedResponse($data = [])
    {
        return $this->responseJson([
            'data'    => $data,
            'message' => 'unauthorized action'
        ], 401);
    }

    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/v'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {
        return strpos($request->getUri(), '/api/v') !== false;
    }

    protected function successResponse($data, $code)
    {
        return $this->responseJson($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return $this->responseJson(['errors' => $message, 'code' => $code], $code);
    }

    protected function messageResponse($message, $code = 200)
    {
        return $this->responseJson(['message' => $message], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->responseJson(['data' => $collection], $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        return $this->responseJson(['data' => $instance], $code);
    }

    protected function responseJson($data, $status = 200)
    {
        return response()->json($data, $status);
    }
}
