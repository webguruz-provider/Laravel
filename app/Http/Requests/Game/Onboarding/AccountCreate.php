<?php

namespace App\Http\Requests\Game\Onboarding;

use Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountCreate extends FormRequest
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
            'email' => [
                'required',
                Rule::unique('users')->ignore(Auth::Id()),
            ],
            'handle' => ['required',
                Rule::unique('users')->ignore(Auth::Id()),
            ]
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Please add your email address.',
            'email.unique:users' => 'Another user already has this email address.',
            'handle.required' => 'Please add a Sided handle.',
            'email.unique:users' => 'This handle has already been taken.'
        ];
    }
}
