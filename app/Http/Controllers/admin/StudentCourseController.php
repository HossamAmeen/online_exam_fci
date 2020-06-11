<?php

namespace App\Http\Controllers\admin;

use App\Course;
use App\Department;
use App\Faculty;
use App\Http\Controllers\Controller;
use App\Imports\StudentCourseImport;
use App\Student;
use App\Student_cource_exam;
use Excel , Redirect;
use Illuminate\Http\Request;
use App\Imports\RegisteredStudentImport;
class StudentCourseController extends Controller
{
    public function index()
    {
        //$Student_cource_exams = Student_cource_exam::all();
        //return view('admin.studentCourses.index', compact('Student_cource_exams'));
		$faculties=Faculty::all();
		return view('admin.studentCourses.index',compact('faculties'));

    }
    public function create()
    {
        $faculties = Faculty::all();
        return view('admin.studentCourses.create', compact('faculties'));
    }
	public function loadRegisterations(Request $request)
	{
		if($request->course_id)
		{
			
			$Student_cource_exams = Student_cource_exam::where('COURSE_ID',$request->course_id)->get();
            return view('admin.studentCourses.indexcontent', compact('Student_cource_exams'));
		}
		else
		{
			$faculty_id = $request->faculty_id;
			$departments = Department::where('FACULTY_ID', $faculty_id)->get()->pluck('id')->toArray();
			$courses = Course::whereIn('DEPARTMENT_ID', $departments)->get()->pluck('id')->toArray();
			$Student_cource_exams = Student_cource_exam::whereIn('COURSE_ID',$courses)->get();
            return view('admin.studentCourses.indexcontent', compact('Student_cource_exams'));
		
		}
	}
    public function store(Request $request)
    {
        foreach ($request->students as $student) {
            foreach ($request->courses as $course) {
                $Student_cource_exams = Student_cource_exam::where('STUDENT_ID', $student)->where('COURSE_ID', $course)->get();
                if ($Student_cource_exams->isEmpty()) {
                    $Student_cource_exam = new Student_cource_exam();
                    $Student_cource_exam->STUDENT_ID = $student;
                    $Student_cource_exam->COURSE_ID = $course;
                    $Student_cource_exam->save();
                }

            }
        }
        return redirect()->route('studentCourses.index');

    }
    
    public function importOld(Request $request)
    {
        // $path = $request->file('import_file')->getRealPath();
        $data = Excel::toArray(new StudentCourseImport, request()->file('import_file'));
        $students_id = array();
        $studentNotFound = array();
        foreach ($data as $items) {
            foreach ($items as $item) {
                foreach ($item as $name) {
                    // return $name;
                    $student = Student::where('STUDENT_NAME', $name)->first();
                    // return
                    if (isset($student)) {
                        $students_id[] = $student->id;
                    } else {
                        $studentNotFound[] = $name;
                    }

                }
            }
        }

        // return $students_id;
        foreach ($students_id as $student) {
            // return $request->courses;
            foreach ($request->courses as $course) {
                $Student_cource_exams = Student_cource_exam::where('STUDENT_ID', $student)->where('COURSE_ID', $course)->get();
                if ($Student_cource_exams->isEmpty()) {
                    $Student_cource_exam = new Student_cource_exam();
                    $Student_cource_exam->STUDENT_ID = $student;
                    $Student_cource_exam->COURSE_ID = $course;
                    $Student_cource_exam->save();
                }

            }
        }
        if (count($studentNotFound) > 0) {
            $faculties = Faculty::all();
            return view('admin.studentCourses.create', compact('faculties', 'studentNotFound'));
        } else {
            return redirect()->route('studentCourses.index');
        }

    }

    public function import( Request $request)
    {
        set_time_limit(800000);
        // return $request->all();
        Excel::import(new RegisteredStudentImport, request()->file('student_sheet'));
        // $students = (new RegisteredStudentImport)->toArray(request()->file('student_sheet'));
        // return $students[0][0][0];
        

        
        // $request->session()->flash('status', 'Task was successful!');
        return Redirect::back();
       
    }
    public function courses(Request $request)
    {
        $faculty_id = $request->faculty_id;
        $departments = Department::where('FACULTY_ID', $faculty_id)->get()->pluck('id')->toArray();
        $courses = Course::whereIn('DEPARTMENT_ID', $departments)->get();
        $data = '';

        foreach ($courses as $course) {
            $data .= '<div class="form-group">
                                    <div class="checkbox">
                                        <input id="remember-7" type="checkbox" value="' . $course->id . '" name="courses[]" class="individual">
                                        <label for="remember-7"> ' . $course->COURSE_NAME . ' </label>
                                    </div>
                                </div>';
        }
        return $data;

    }

    public function getCourses(Request $request)
    {
        ////// for select course in import excel sheet
        
        $faculty_id = $request->faculty_id;
        $departments = Department::where('FACULTY_ID', $faculty_id)->get()->pluck('id')->toArray();
        $courses = Course::whereIn('DEPARTMENT_ID', $departments)->get(['id' , 'COURSE_NAME']);
        $data = '';
       
      
        return $courses;

    }
	public function getDepartmentCourses(Request $request)
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
    public function students(Request $request)
    {
        $faculty_id = $request->faculty_id;
        $students = Student::where('FACULTY_ID', $faculty_id)->get();
        $data = '';

        foreach ($students as $student) {
            $data .= '<div class="form-group">
                                    <div class="checkbox">
                                        <input id="remember-7" type="checkbox" value="' . $student->id . '" name="students[]" class="individual2">
                                        <label for="remember-7"> ' . $student->STUDENT_NAME . ' </label>
                                    </div>
                                </div>';
        }
        return $data;

    }
}
