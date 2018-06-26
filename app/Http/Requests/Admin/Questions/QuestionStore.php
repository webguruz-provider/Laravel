<?php

namespace App\Http\Requests\Admin\Questions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class QuestionStore extends FormRequest
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
        if($this->request->has('publish_at')) {
            return [
                'text' => 'required',
                'category_id' => 'required',
                'publish_at' => 'required',
                'expire_at' => 'required'
            ];
        }else{
            return [
                'text' => 'required',
                'category_id' => 'required',
                'expire_at' => 'required'
            ];
        }
    }

    public function messages()
    {
        return [
            'text.required' => 'Please enter question text.',
            'category_id.required' => 'Choose category.',
            'publish_at.required' => 'Please select publish date.',
            'expire_at.required' => 'Please select expire date.',
        ];
    }
}
