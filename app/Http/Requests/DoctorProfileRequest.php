<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorProfileRequest extends FormRequest
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
             'type'=>'required',
             'point'=>'required',
             'start_time'=>'required',
             'date'=>'required',
             'time'=>'required',
             'course_id'=>'required',
         ];
     }
     public function messages()
     {
         return [
             'name.required' => 'A Name is required',
             'type.required'  => 'A Type is required',
             'point.required' => 'A Point is required',
             'start_time.required'  => 'A Start Time is required',
             'date.required' => 'A Date is required',
             'time.required'  => 'A Time is required',
             'course_id.required' => 'A Courses are required',
         ];
     }
}
