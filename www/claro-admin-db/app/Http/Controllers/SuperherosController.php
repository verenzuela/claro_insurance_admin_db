<?php

namespace App\Http\Controllers;

use App\Models\Superhero;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\SuperheroPostRequest;
use App\Http\Requests\SuperheroPutRequest;
use Illuminate\Http\Request;

class SuperherosController extends Controller
{
    use ApiResponse;


    public function index(Request $request)
    {
        try {
            if (!Auth::user()->can('superhero.list')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $superheros = Superhero::paginate($request->input('item_per_page'));
            return $this->successResponse('superheros list', $superheros);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function store(SuperheroPostRequest $request)
    {
        try {
            if (!Auth::user()->can('superhero.create')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $superhero = Superhero::create($request->only('name', 'gender'));
            return $this->successResponse('superhero created successful', $superhero);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function update(SuperheroPutRequest $request, $id)
    {
        try {
            if (!Auth::user()->can('superhero.edit')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $superhero = Superhero::findOrFail($id);
            $superhero->setAttribute('name', $request->input('name'));
            $superhero->setAttribute('gender', $request->input('gender'));
            $superhero->save();

            return $this->successResponse('superhero updated successful', $superhero);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }


    public function destroy($id)
    {
        try {
            if (!Auth::user()->can('superhero.delete')) {
                return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED,'');
            }

            $superhero = Superhero::findOrFail($id);
            $superhero->delete();

            return $this->successResponse('superhero delete successful', $superhero);

        } catch (\Throwable $error) {
            return $this->errorResponse($error->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR,'');
        }
    }
}
