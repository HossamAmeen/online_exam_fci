<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'code'=>'required',
            'collage'=>'required',
            'department'=>'required',
            'courses'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'A Name is required',
            'email.required'  => 'A Email is required',
            'password.required' => 'A Password is required',
            'code.required'  => 'A code is required',
            'collage.required' => 'A collage is required',
            'department.required'  => 'A Department is required',
            'courses.required' => 'A Courses are required',
        ];
    }
}
