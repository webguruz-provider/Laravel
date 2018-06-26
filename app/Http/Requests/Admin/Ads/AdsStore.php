<?php

namespace App\Http\Requests\Admin\Ads;

use Illuminate\Foundation\Http\FormRequest;

class AdsStore extends FormRequest
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
            'name' => 'required',
            'avatar_url' => 'required|image|mimes:jpeg,png,jpg',
            'weburl' => 'required',
            'advertisement_type' => 'required',
            'cpm' => 'required|integer',
            'publish_at' => 'required',
            'expire_at' => 'required'
        ];
       
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter ad name.',
            'avatar_url.required' => 'Please upload ad image.',
            'avatar_url.image' => 'The image must be an image.',
            'avatar_url.mimes' => 'The image must be a file of type: jpeg, jpg, png.',
            'weburl.required' => 'Please enter ad url.',
            'advertisement_type.required' => 'Choose advertisement type.',
            'cpm.required' => 'Please enter ad cpm.',
            'cpm.integer' => 'Please enter a numeric value.',
            'publish_at.required' => 'Please select publish date.',
            'expire_at.required' => 'Please select expire date.',
        ];
    }
}
