<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\FruitPostRequest;
use App\Http\Requests\FruitPutRequest;
use Illuminate\Http\Request;

class FruitController extends Controller
{
    use ApiResponse;


    public function index(Request $request)
    {
        try {
            if (!Auth::user()->can('fruit.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $fruits = Fruit::paginate($request->input('item_per_page'));
            return $this->successResponse('fuits list', $fruits);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function store(FruitPostRequest $request)
    {
        try {
            if (!Auth::user()->can('fruit.create')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $fruit = Fruit::create($request->only('name', 'quantity'));
            return $this->successResponse('fruit created successful', $fruit);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function update(FruitPutRequest $request, $id)
    {
        try {
            if (!Auth::user()->can('fruit.edit')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $fruit = Fruit::findOrFail($id);
            $fruit->setAttribute('name', $request->input('name'));
            $fruit->setAttribute('quantity', $request->input('quantity'));
            $fruit->save();

            return $this->successResponse('fruit updated successful', $fruit);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function destroy($id)
    {
        try {
            if (!Auth::user()->can('fruit.delete')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $fruit = Fruit::findOrFail($id);
            $fruit->delete();

            return $this->successResponse('fruit delete successful', $fruit);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }
}
