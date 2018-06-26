<?php

namespace App\Http\Requests\Admin\Advertisers;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class AdvertiserUpdate extends FormRequest
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
        $id = $request->get('advertiser_id');
        return [
            'company_name' => 'required',
            'contact_name' => 'required',
            'phone' => 'required|regex:/[0-9]{9}/',
            'email' => [
                'required','email',
                Rule::unique('advertisers')->ignore($id),
            ],
            'agreement' => 'required'
        ];
       
    }

    public function messages()
    {
        return [
            'company_name.required' => 'Please enter company name.',
            'contact_name.required' => 'Please enter contact name.',
            'phone.required' => 'Please enter phone number.',
            'phone.regex' => 'The phone format is invalid',
            'email.required' => 'Please enter email.',
            'email.email' => 'Please enter valid email.',
            'email.unique' => 'This email has already been used.',
            'agreement.required' => 'Please select agreement.',
        ];
    }
}
