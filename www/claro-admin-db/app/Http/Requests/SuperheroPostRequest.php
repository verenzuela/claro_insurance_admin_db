<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use \App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class SuperheroPostRequest extends FormRequest
{
    use ApiResponse;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:superheros',
            'gender' => 'required|string|in:male,female,other',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('labels.name'),
            'gender' => __('labels.gender'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorResponse('Validations fails.', Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors())
        );
    }
}
