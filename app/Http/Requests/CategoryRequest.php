<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return match($this->method()){
            'POST' => [
                'name' => 'required|string|unique:categories,name',
            ],
            'PATCH','PUT' => [
                'id' => 'required|numeric',
                'name' => "required|string|unique:categories,name,$this->id",
            ],
        };
    }

    protected function failedValidation(Validator $validator)
    {
        response()->sendValidationErrorResponse($validator->errors());
    }
}
