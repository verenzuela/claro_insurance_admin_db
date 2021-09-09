<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait ApiResponse
{
    public function successResponse($message, $data, $code = ResponseAlias::HTTP_OK): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'code' => $code,
            'status' => true
        ], $code);
    }

    public function serviceResponse($data, $code = ResponseAlias::HTTP_OK)
    {
        return response($data, $code)->header('Content-Type', 'application/json');
    }

    public function errorResponse($message, $code = 500, $data = null): \Illuminate\Http\JsonResponse
    {
        $code = (is_numeric($code) and $code > 0) ? $code : 500;

        return response()->json([
            'message' => $message,
            'data' => $data,
            'code' => $code,
            'status' => false
        ], $code);
    }

    public function messageResponse($message, $code)
    {
        return response($message, $code)->header('Content-Type', 'application/json');
    }

}
