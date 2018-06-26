<?php

namespace App\Http\Requests\Admin\Event;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class EventUpdate extends FormRequest
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
                'event_description' => 'required',
                'category_id' => 'required',
                'publish_at' => 'required',
                'expire_at' => 'required'
            ];
        }else{
            return [
                'name' => 'required',
                'weburl' => 'required',
                'event_description' => 'required',
                'category_id' => 'required',
                'publish_at' => 'required',
                'expire_at' => 'required'
            ];
        }
       
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter event name.',
            'avatar_url.required' => 'Please upload event image.',
            'avatar_url.image' => 'The image must be an image.',
            'avatar_url.mimes' => 'The image must be a file of type: jpeg, jpg, png.',
            'weburl.required' => 'Please enter event url.',
            'event_description.required' => 'Please enter event description.',
            'category_id.required' => 'Choose category.',
            'publish_at.required' => 'Please select publish date.',
            'expire_at.required' => 'Please select expire date.'
        ];
    }
}
