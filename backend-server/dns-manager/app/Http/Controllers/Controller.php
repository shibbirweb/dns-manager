<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    public function successResponse($data, $message = 'Success',  $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'code' => $code,
            'message' => $message,
        ], $code);
    }

    public function errorResponse($message, $code): JsonResponse
    {
        return response()->json([
            'error' => $message,
            'code' => $code
        ], $code);
    }
}
