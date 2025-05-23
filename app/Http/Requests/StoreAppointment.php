<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointment extends FormRequest
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
              //'exists_client' => 'required',
              //'new_client' => 'required',
              'mobile' => 'required',
              'date' => 'required',
              'time' => 'required',
        ];
    }
      public function messages()
    {
        return [
              //'exists_client.required' => 'Please select client.',
              //'new_client.required' => 'Please enter client name',
         
              'mobile.required' => 'Please enter mobile.',
              'date.required' => 'Please select date.',
              'time.required' => 'Please select time',
            

        ];
    }
}
