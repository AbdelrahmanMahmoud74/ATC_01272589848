<?php

namespace App;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function successResponse($data, string $message = 'Operation successful', int $code = 200, array $extra = []):JsonResponse
    {
        return response()->json(array_merge([

            'message' => $message,
            'data' => $data,
        ], $extra), $code);
    }
    public function notfoundResponse($data, string $message = 'not found', int $code = 404):JsonResponse
    {
        return response()->json(array_merge([

            'message' => $message,
            'data' => $data,
        ]), $code);
    }
}
