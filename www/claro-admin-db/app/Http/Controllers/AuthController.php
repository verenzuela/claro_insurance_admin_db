<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterPostRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * @param RegisterPostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterPostRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->input("name"),
                'email' => $request->input("email"),
                'password' => Hash::make($request->input("password"))
            ]);
            return $this->successResponse('User registered.', $this->getUserInfo($user));

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }

    /**
     * @param LoginPostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginPostRequest $request): \Illuminate\Http\JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->errorResponse('Invalid user or password', Response::HTTP_UNAUTHORIZED, '');
        }

        try {
            $user = User::where('email', '=', $request->input('email'))->firstOrFail();
            return $this->successResponse('Login success', $this->getUserInfo($user));

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse('Logout success', '');
    }


    /**
     * @param User $user
     * @return array
     */
    protected function getUserInfo(User $user): array
    {
        return [
            'token_type' => 'Bearer',
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'name' => $user->getAttributeValue('name'),
            'email' => $user->getAttributeValue('email'),
            'roles' => [],
            'permissions' => []
        ];
    }
}
