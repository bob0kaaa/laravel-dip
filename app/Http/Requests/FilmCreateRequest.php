<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FilmCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'required'],
            'description' => ['string', 'required'],
            'duration' => ['integer', 'required', 'max:200'],
            'origin' => ['string', 'required' ],
            'imageText' => ['string'],
            'imagePath' => ['file', 'required'],
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response($validator->errors(), 400)
        );
    }
}
