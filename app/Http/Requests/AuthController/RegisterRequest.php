<?php

namespace App\Http\Requests\AuthController;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
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
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'email',
                'required',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'string',
                'required',
                'confirmed',
            ],
        ];
    }
}
