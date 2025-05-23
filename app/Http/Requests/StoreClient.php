<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
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

           'f_name' => 'required',
            'l_name' => 'required',
            'm_name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city_id' => 'required',
            //'email' => 'required',
            'mobile' => 'required',
            //'alternate_no' => 'required',
            'gender' => 'required',

        ];
    }

    public function messages()
    {
        return [

            'f_name.required' => 'Please enter first name.111',
            'l_name.required' => 'Please enter middle name.',
            'm_name.required' => 'Please enter last name.',
            'address.required' => 'Please enter address.',
            'country.required' => 'Please select country.',
            'state.required'    => 'Please select state.',
            'city_id.required'  => 'Please select city.',
            //'email' => 'required',
            'mobile.required' => 'Please enter mobile.',
            //'alternate_no' => 'required',
            //'gender.required' => 'Gender is required',

        ];
    }
}
