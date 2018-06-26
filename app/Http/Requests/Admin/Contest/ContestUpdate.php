<?php

namespace App\Http\Requests\Admin\Contest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class ContestUpdate extends FormRequest
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
    public function rules(Request $request)
    {
        if($request->hasFile('avatar_url')) {
            return [
                'name' => 'required',
                'avatar_url' => 'required|image|mimes:jpeg,png,jpg',
                'weburl' => 'required',
                'contest_description' => 'required',
                'category_id' => 'required',
                'publish_at' => 'required',
                'expire_at' => 'required'
            ];
        }else{
            return [
                'name' => 'required',
                'weburl' => 'required',
                'contest_description' => 'required',
                'category_id' => 'required',
                'publish_at' => 'required',
                'expire_at' => 'required'
            ];
        }
       
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter contest name.',
            'avatar_url.required' => 'Please upload contest image.',
            'avatar_url.image' => 'The image must be an image.',
            'avatar_url.mimes' => 'The image must be a file of type: jpeg, jpg, png.',
            'weburl.required' => 'Please enter contest url.',
            'contest_description.required' => 'Please enter contest description.',
            'category_id.required' => 'Choose category.',
            'publish_at.required' => 'Please select publish date.',
            'expire_at.required' => 'Please select expire date.'
        ];
    }
}
