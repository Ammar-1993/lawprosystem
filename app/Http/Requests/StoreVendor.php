<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendor extends FormRequest
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
            //
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city_id' => 'required',
            'mobile' => 'required',
        ];
    }
    public function messages()
    {
        return [

            'address.required'    => 'Please enter address.',
            'country.required'    => 'Please select country.',
            'state.required'      => 'Please select state.',
            'city_id.required'    => 'Please select city.',
            'mobile.required'     => 'Please enter mobile.',

        ];
    }
}
