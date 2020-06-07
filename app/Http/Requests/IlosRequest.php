<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IlosRequest extends FormRequest
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
             'type_id'=>'required',
             'faculty_id'=>'required',
             'course_id'=>'required',
             'ilos_name'=>'required',
         ];
     }
     public function messages()
     {
         return [
             'type_id.required' => 'A Name is required',
             'faculty_id.required'  => 'A faculty is required',
             'course_id.required' => 'A course is required',
             'ilos_name.required'  => 'A ilos is required',
         ];
     }
   }
