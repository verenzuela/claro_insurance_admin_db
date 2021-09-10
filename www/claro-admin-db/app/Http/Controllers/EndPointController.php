<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\EndPoint;
use App\Models\User;
use App\Http\Requests\EnpointPostRequest;
use App\Http\Requests\EnpointPutRequest;
use App\Http\Requests\EnpointAddUserRequest;
use Illuminate\Http\Request;

class EndPointController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            if (!Auth::user()->can('endpoint.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $endpoints = EndPoint::paginate($request->input('item_per_page'));
            return $this->successResponse('endpoint list', $endpoints);
        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function store(EnpointPostRequest $request)
    {
        try {
            if (!Auth::user()->can('endpoint.create')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $endpoint = EndPoint::create($request->only('name'));
            return $this->successResponse('endpoint created successful', $endpoint);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function update(EnpointPutRequest $request, $id)
    {
        try {
            if (!Auth::user()->can('endpoint.edit')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $endpoint = EndPoint::findOrFail($id);
            $endpoint->setAttribute('name', $request->input('name'));
            $endpoint->save();

            return $this->successResponse('endpoint updated successful', $endpoint);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function destroy($id)
    {
        try {
            if (!Auth::user()->can('endpoint.delete')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $endpoint = EndPoint::findOrFail($id);
            $endpoint->delete();

            return $this->successResponse('endpoint delete successful', $endpoint);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function usersAssigned($id): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('endpoint.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $endpoint = EndPoint::findOrFail($id);
            $endpoint->load('users');

            return $this->successResponse('endpoint users', $endpoint);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function addUser(EnpointAddUserRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('endpoint.edit')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $endpoint = EndPoint::findOrFail($id);
            $user = User::findOrFail($request->input('user_id'));
            $endpoint->users()->attach($user);

            $endpoint->fresh();
            $endpoint->load('users');

            return $this->successResponse('endpoint user add', $endpoint);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function removeUser($endpoint_id, $user_id): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('endpoint.delete')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $endpoint = EndPoint::findOrFail($endpoint_id);
            $user = User::findOrFail($user_id);
            $endpoint->users()->detach($user);

            return $this->successResponse('endpoint user delete', '');

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }
}
