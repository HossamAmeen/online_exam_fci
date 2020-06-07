<?php

namespace App\Http\Controllers\admin;

use App\Course;
use App\Faculty;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorRequest;
use App\Staff;
use App\Staff_course;
use App\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $faculites = Faculty::all();
        $staffs = Staff::all();
        return view('admin.doctor.index', compact('faculites', 'staffs'));
    }

    public function store(DoctorRequest $request)
    {
//        dd($request->all());
        $user=User::where('email', $request->email)->first();
        if($user){
            return back()->withErrors(['error'=>'Email Found Before']);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 2;
        $user->password = bcrypt($request->password);
        $user->save();
        $doctor = new Staff();
        $doctor->STAFF_NAME = $request->name;
        $doctor->phone = $request->code;
        $doctor->FACULTY_ID = $request->collage;
        $doctor->DEPARTMENT_ID = $request->department;
        $doctor->user_id = $user->id;
        $doctor->save();
        foreach ($request->courses as $course)
        {
            $cou_doc = new Staff_course();
            $cou_doc->STAFF_ID = $doctor->id;
            $cou_doc->COURSE_ID = $course;
            $cou_doc->save();
        }

        return redirect()->route('doctor.index');
    }//end of store

    public function update(DoctorRequest $request, Staff $doctor)
    {
        $user=User::where('email', $request->email)->where('id','!=',$doctor->user->id)->first();
//        dd($user);
        if($user){
            return back()->withErrors(['error'=>'Email Found Before']);
        }
//        dd($user);
        $user=$doctor->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 2;
        $user->password = bcrypt($request->password);
        $user->save();

        $doctor->STAFF_NAME = $request->name;
        $doctor->phone = $request->code;
        $doctor->FACULTY_ID = $request->collage;
        $doctor->DEPARTMENT_ID = $request->department;
        $doctor->user_id = $user->id;
        $doctor->save();

        $course_doctor=Staff_course::where('STAFF_ID',$doctor->id)->get();
        foreach ($course_doctor as $course)
        {
            $course->delete();
        }
        foreach ($request->courses as $course)
        {
            $cou_doc = new Staff_course();
            $cou_doc->STAFF_ID = $doctor->id;
            $cou_doc->COURSE_ID = $course;
            $cou_doc->save();
        }
        return redirect()->route('doctor.index');

    }
    public function destroy(Staff $doctor)
    {
        $doctor->user->delete();
        $doctor->delete();
        return redirect()->route('doctor.index');

    }//end of destroy

    public function getCourses(Request $request)
    {
        $depart_select='';
        if($request->depart)
            $depart_select=$request->depart;
        $courses=Course::where('DEPARTMENT_ID',$request->depart)->get();
        $data='';

        foreach ($courses as $course)
        {
            $data.='<option ';
//            if($depart_select ==$department->id)
//                $data.= ' selected';
            $data.= ' value="'.$course->id.'">'.$course->COURSE_NAME.'</option>';
        }
        return $data;
    }

}
