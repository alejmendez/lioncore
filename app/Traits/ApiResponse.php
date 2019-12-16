<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponse
{
    /**
     * Show json individual response
     * @param type $data
     * @return type
     */
    protected function createdResponse($data) 
    {
        $response = [
            'code'   => 201,
            'status' => 'success',
            'data'   => $data
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Show json individual response
     * @param type $data
     * @return type
     */
    protected function showResponse($data) 
    {
        $response = [
            'code'   => 200,
            'status' => 'success',
            'data'   => $data,
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * List json individual response with paginate
     * @param type $data
     * @return type
     */
    protected function listResponse($data) 
    {
        $response = [
            'code'      => 200,
            'status'    => 'success',
            'data'      => $data->all(),
            'paginator' => [
                'pages'        => (int) $data->lastPage(),
                'current_page' => (int) $data->currentPage(),
                'per_page'     => (int) $data->perPage(),
                'total'        => (int) $data->total(),
            ],
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Not found response
     * @return type
     */
    protected function notFoundResponse() 
    {
        $response = [
            'code'    => 404,
            'status'  => 'error',
            'data'    => 'Resource Not Found',
            'message' => 'Not Found'
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Deleted response
     * @return type
     */
    protected function deletedResponse() 
    {
        $response = [
            'code'    => 200,
            'status'  => 'success',
            'data'    => 'Resource deleted',
            'message' => 'Deleted'
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Client error response
     * @param type $data
     * @return type
     */
    protected function clientErrorResponse($data) 
    {
        $response = [
            'code'    => 422,
            'status'  => 'error',
            'data'    => $data,
            'message' => 'Unprocessable entity'
        ];
        return response()->json($response, $response['code']);
    }

    /**
     * Client Unauthorized response
     * @param type $data
     * @return type
     */
    protected function clientUnauthorizedResponse($data = []) 
    {
        $response = [
            'code'    => 401,
            'status'  => 'unauthenticated',
            'data'    => $data,
            'message' => 'unauthorized action'
        ];
        return response()->json($response, $response['code']);
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
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['errors' => $message, 'code' => $code], $code);
    }

    protected function messageResponse($message, $code = 200)
    {
        return response()->json(['message' => $message], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        return response()->json(['data' => $collection], $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        return response()->json(['data' => $instance], $code);
    }
}
