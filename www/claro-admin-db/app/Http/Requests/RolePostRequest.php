<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class RolePostRequest extends FormRequest
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
            'name' => 'required|max:255|string|unique:roles',
            'display_name' => 'nullable|max:255|string|',
            'description' => 'nullable|max:255|string|'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('labels.name'),
            'display_name' => __('labels.display_name'),
            'description' => __('labels.description')
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorResponse('Validations fails.', Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors())
        );
    }
}
