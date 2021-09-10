<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EndPointController;
use App\Http\Controllers\FruitController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SuperherosController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user/profile', [UserController::class, 'index']);
    Route::put('/user/profile', [UserController::class, 'update']);
    Route::get('/user/roles', [UserController::class, 'assignedRoles']);
    Route::post('/user/{user_id}/rol/{rol_id}/add', [UserController::class, 'rolAdd']);
    Route::delete('/user/{user_id}/rol/{rol_id}/delete', [UserController::class, 'rolDelete']);

    Route::get('/user/endpoints', [UserController::class, 'assignedEndpoints']);
    Route::get('/user/without/endpoints', [UserController::class, 'withoutEndpoints']);

    Route::resource('/roles', RoleController::class)->except(['show', 'create', 'edit']);
    Route::get('/rol/{id}/permissions', [RoleController::class, 'rolePermissions']);
    Route::post('/rol/{id}/permission-add', [RoleController::class, 'addPermission']);
    Route::delete('/rol/{role_id}/permission/{permission_id}/delete', [RoleController::class, 'removePermission']);


    Route::resource('/permissions', PermissionController::class)->except(['show','create', 'edit']);

    Route::resource('/endpoints', EndPointController::class)->except(['show', 'create', 'edit']);
    Route::get('/endpoints/{id}/users', [EndPointController::class, 'usersAssigned']);    
    Route::post('/endpoints/{id}/add-user', [EndPointController::class, 'addUser']);
    Route::delete('/endpoints/{endpoint_id}/delete-user/{user_id}', [EndPointController::class, 'removeUser']);
    
    Route::resource('/fruits', FruitController::class)->except(['show', 'create', 'edit']);
    
    Route::resource('/superheros', SuperherosController::class)->except(['show', 'create', 'edit']);

});

