<?php

namespace Modules\Core\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponse
{
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
