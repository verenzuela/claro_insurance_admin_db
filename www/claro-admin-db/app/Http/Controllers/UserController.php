<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\ViewUsersEndpoint;
use App\Models\ViewUsersWithoutEndpoint;
use App\Http\Requests\UserProfileUpdateRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->hasRole('admin')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
            }

            $user = User::paginate($request->input('item_per_page'));
            $user->load('roles');
            $user->load('endpoints');

            return $this->successResponse('User list.', $user);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function profile(): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('user.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
            }

            $user = User::findOrFail(Auth::user()->id);
            return $this->successResponse('User profile.', $user);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UserProfileUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('user.edit')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
            }

            $user = User::findOrFail(Auth::user()->id);
            $user->setAttribute('name', $request->input('name'));
            $user->setAttribute('email', $request->input('email'));
            $user->setAttribute('password', Hash::make($request->input("password")));
            $user->save();

            return $this->successResponse('User profile updated.', $user);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function assignedRoles(): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->hasRole('admin')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
            }

            $users = User::all();
            $users->load('roles');

            return $this->successResponse('User profile.', $users);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function rolAdd($user_id, $rol_id): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->hasRole('admin')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
            }

            $user = User::findOrFail($user_id);
            $rol = Role::findOrFail($rol_id);
            $user->roles()->attach($rol);

            $user->fresh();
            $user->load('roles');

            return $this->successResponse('User profile.',$user);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function rolDelete($user_id, $rol_id): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->hasRole('admin')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
            }

            $user = User::findOrFail($user_id);
            $rol = Role::findOrFail($rol_id);
            $user->roles()->detach($rol);

            $user->fresh();
            $user->load('roles');

            return $this->successResponse('User profile.',$user);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
    public function myEndpoints(): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('user.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
            }

            $user = User::findOrFail(Auth::user()->id);
            $user->load('endpoints');

            return $this->successResponse('User endpoints.',$user);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function assignedEndpoints(): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->hasRole('admin')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
            }

            $users = ViewUsersEndpoint::all();

            return $this->successResponse('User whit endpoints.',$users);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function withoutEndpoints(): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->hasRole('admin')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
            }

            $users = ViewUsersWithoutEndpoint::all();

            return $this->successResponse('User without endpoints.', $users);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
