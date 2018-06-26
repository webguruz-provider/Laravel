<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStore extends FormRequest
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
            'cat_name' => 'required',
            'avatar_url' => 'required|image|mimes:jpeg,png,jpg'
        ];
       
    }

    public function messages()
    {
        return [
            'cat_name.required' => 'Please enter category name.',
            'avatar_url.required' => 'Please upload category image.',
            'avatar_url.image' => 'The image must be an image.',
            'avatar_url.mimes' => 'The image must be a file of type: jpeg, jpg, png.'
        ];
    }
}
