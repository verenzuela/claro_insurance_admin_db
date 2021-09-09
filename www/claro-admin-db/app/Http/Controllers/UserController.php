<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use ApiResponse;

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {

            return $this->successResponse('User registered.',[]);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }
}
