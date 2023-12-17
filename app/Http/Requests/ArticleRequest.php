<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
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
                'title' => 'required|string|unique:articles,title',
                'content' => 'required|string',
                'categories' => 'required',
                'categories.*' => 'numeric'
            ],
            'PATCH','PUT' => [
                'id' => 'required|numeric',
                'title' => "required|string|unique:articles,title,$this->id",
                'content' => 'required|string',
                'categories' => 'nullable',
                'categories.*' => 'numeric',
                'status' => Rule::in(['published', 'draft'])
            ],
        };
    }

    protected function failedValidation(Validator $validator)
    {
        response()->sendValidationErrorResponse($validator->errors());
    }
}
