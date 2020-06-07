<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */


       public function rules()
       {
           return [
               'name'=>'required',
               'email'=>'required|unique:users',
               'password'=>'required',
               'faculty'=>'required',
               'department'=>'required',
               'term'=>'required',
               'year'=>'required',
               'phone'=>'required',
               'snn'=>'required',
           ];
       }
       public function messages()
       {
           return [
               'name.required' => 'A Name is required',
               'email.required'  => 'A Email is required',
               'email.unique'  => 'A Email is Aready exists',
               'password.required' => 'A Password is required',
               'faculty.required'  => 'A Faculty is required',
               'department.required' => 'A Department is required',
               'term.required'  => 'A Term is required',
               'year.required' => 'A Year are required',
               'phone.required' => 'A Phone are required',
               'snn.required' => 'A SNN are required',
           ];
       }
}
