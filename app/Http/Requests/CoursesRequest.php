<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursesRequest extends FormRequest
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
             'code'=>'required',
             'collage'=>'required',
             'level'=>'required',
             'term'=>'required',
             'department'=>'required'
             //'file'=>'required'
         ];
     }
     public function messages()
     {
         return [
             'name.required' => 'A Name is required',
             'code.required'  => 'A Code is required',
             'collage.required' => 'A Collage is required',
             'level.required'  => 'A Level is required',
             'term.required' => 'A Term is required',
             'department.required'  => 'A Department is required'
            // 'file.required' => 'A File are required',
         ];
     }
}
