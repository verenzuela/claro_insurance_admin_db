<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolePostRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    use ApiResponse;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Auth::user()->can('permission.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $permissions = Permission::all();
            return $this->successResponse('roles list', $permissions);
        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function store(PermissionPostRequest $request)
    {
        //
    }


    public function update(PermissionPutRequest $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
