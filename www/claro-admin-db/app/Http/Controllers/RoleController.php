<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleAddPermissionRequest;
use App\Http\Requests\RolePostRequest;
use App\Http\Requests\RolePutRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    use ApiResponse;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('role.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $roles = Role::all();
            return $this->successResponse('roles list', $roles);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    /**
     * @param RolePostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RolePostRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('role.create')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $rol = Role::create($request->only('name', 'display_name', 'description'));
            return $this->successResponse('roles created successful', $rol);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    /**
     * @param RolePutRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RolePutRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('role.edit')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $rol = Role::findOrFail($id);
            $rol->setAttribute('name', $request->input('name'));
            $rol->setAttribute('display_name', $request->input('display_name'));
            $rol->setAttribute('description', $request->input('description'));
            $rol->save();

            return $this->successResponse('roles updated successful', $rol);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('role.edit')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $rol = Role::findOrFail($id);
            $rol->delete();

            return $this->successResponse('roles delete successful', $rol);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function rolePermissions($id): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('role.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $rol = Role::findOrFail($id);
            $rol->load('permissions');

            return $this->successResponse('roles permission', $rol);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    /**
     * @param RoleAddPermissionRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addPermission(RoleAddPermissionRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('role.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $rol = Role::findOrFail($id);
            $permission = Permission::findOrFail($request->input('permission_id'));
            $rol->permissions()->attach($permission);

            $rol->fresh();
            $rol->load('permissions');

            return $this->successResponse('role permission add', $rol);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    /**
     * @param $role_id
     * @param $permission_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removePermission($role_id, $permission_id): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('role.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $rol = Role::findOrFail($role_id);
            $permission = Permission::findOrFail($permission_id);
            $rol->permissions()->detach($permission);

            return $this->successResponse('role permission delete', '');

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }

}
