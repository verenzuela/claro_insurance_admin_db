<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\PermissionPostRequest;
use App\Http\Requests\PermissionPutRequest;

class PermissionController extends Controller
{
    use ApiResponse;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('permission.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $permissions = Permission::paginate($request->input('item_per_page'));
            return $this->successResponse('roles list', $permissions);
        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function store(PermissionPostRequest $request)
    {
        try {
            if (!Auth::user()->can('permission.create')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $permission = Permission::create($request->only('name', 'display_name', 'description'));
            return $this->successResponse('permission created successful', $permission);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function update(PermissionPutRequest $request, $id)
    {
        try {
            if (!Auth::user()->can('permission.edit')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $permission = Permission::findOrFail($id);
            $permission->setAttribute('name', $request->input('name'));
            $permission->setAttribute('display_name', $request->input('display_name'));
            $permission->setAttribute('description', $request->input('description'));
            $permission->save();

            return $this->successResponse('permission updated successful', $permission);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function destroy($id)
    {
        try {
            if (!Auth::user()->can('permission.edit')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $permission = Permission::findOrFail($id);
            $permission->delete();

            return $this->successResponse('permission delete successful', $permission);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }
}
