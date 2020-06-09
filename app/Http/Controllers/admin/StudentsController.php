<?php

namespace App\Http\Controllers\admin;

use App\Department;
use App\DepartmentClass;
use App\Faculty;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Student;
use App\User;
use Excel;
use App\Imports\StudentImport;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
//    bcrypt
    public function index()
    {
        $faculites = Faculty::all();
        return view('admin.students.index', compact('faculites'));
    }
    public function store_student(Request $request)
    {
        if($request->isMethod('post'))
        {
           
            $user = User::where('email', $request->snn)->first();
                if ($user) {
                    return back()->withErrors(['error' => 'snn Found Before']);
                  
                }
                            $user = new User();
                            $user->name =  $request->name;
                            $user->email =  $request->snn;
                            $user->role = 4;
                            $user->password =  bcrypt($request->snn);
                            $user->save();
                            $student = new Student();
                            $student->STUDENT_NAME =$request->name;
                            $student->FACULTY_ID = $request->faculty;
                            $student->DEPARTMENT_ID = $request->department;
                            $student->STUDENT_SSN = $request->snn;
                            $student->STUDENT_PASSWORD = bcrypt($request->snn);
                          
                            $student->term = 1;
                            $student->semester = "2020 -2021";
                            $student->phone = "010";
                            $student->user_id = $user->id;
                            $student->save();
                            session()->flash('addNewStudent' , "add new student successfully");
                            
                            return redirect()->back();
                            
        }
        $faculites = Faculty::all();
        return view('admin.students.new_store', compact('faculites'));
    }
    public function search_student()
    {
        $student = Student::where( 'STUDENT_SSN' , request('snn') )->orWhere( 'STUDENT_NAME' , request('name'))->first();
        $faculites = Faculty::all();
        if($student)
       $departments =  Department::where('FACULTY_ID' , $student->FACULTY_ID)->get();
        // return
        return view('admin.students.new_store', compact('faculites' , 'student' , 'departments'));
    }
    public function update_student(Request $request , $id)
    {
        $student = Student::findOrFail($id);
        $student->STUDENT_NAME =$request->name;
        $student->DEPARTMENT_ID = $request->department;
        $student->STUDENT_SSN = $request->snn;
        $student->save();
        session()->flash('updateStudent' , "update student successfully");
        
        return redirect()->route('new.student.index');
        
     
    }
    public function registerStudent()
    {
      $faculites = Faculty::all();
//        $students=Student::all();
      return view('student.register', compact('faculites'));
    }
    public function existEmail(Request $request)
    {
      $user = User::where('email', $request->email)->first();
      if ($user) {
          //return back()->withErrors(['error' => 'Email Found Before']);
        return 'yes';
      }

      return 'no';
    }
    public function storeStudent(Request $request)
    {
      $faculites = Faculty::all();
      $user = User::where('email', $request->email)->first();
      if ($user) {
          //return back()->withErrors(['error' => 'Email Found Before']);
          $responsecode=2;
          return view('student.register', compact('faculites','responsecode'));
      }
        //        dd($request->all());
      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->role = 4;

      $user->password = bcrypt($request->password);
      $user->save();
      $student = new Student();
      $student->STUDENT_NAME = $request->name;
      $student->FACULTY_ID = $request->faculty;
      $student->DEPARTMENT_ID = strcmp($request->department,'select department')!=0?$request->department:-1;
      $student->class_id = strcmp($request->class,'select class')!=0?$request->class:-1;

      $student->STUDENT_SSN = $request->ssn;
      $student->STUDENT_PASSWORD = bcrypt($request->password);
      $student->STUDENT_EMAIL = $request->email;
      $student->stage = $request->stage;
      // $student->term = $request->term;
      // $student->semester = $request->year;
      // $student->phone = $request->phone;
      $student->user_id = $user->id;
      $student->save();
      $responsecode=1;
      //dd($responsecode);
      return view('student.register', compact('responsecode'));
    }
    public function getStudentIndex(Request $request)
    {
        $faculites = Faculty::all();
        $students = Student::where('DEPARTMENT_ID', $request->department)->get();
        //        dd($students);
        return view('admin.students.index', compact('faculites', 'students'));
    }
   
    public function importExcel(Request $request)
    {
        set_time_limit(800000);
        $request->validate([
            'import_file' => 'required',
            'faculty' => 'required',
            'department' => 'required',
        ]);

        $path = $request->file('import_file')->getRealPath();
        // $data = Excel::load($path)->get();
        $data = Excel::toArray(new StudentImport ,$request->file('import_file') );
            //    dd($data);
            $data = $data[0];
                // dd($data);
                // return $data;
        try {

            if (count($data)) {
                foreach ($data as $key => $value) {
                    // dd($value[0]);
                    foreach ($value as $k => $v) {
                        // return  $v ;
                        $us = Student::where('STUDENT_SSN', $value[1])->first();
                        if ($us) {

                        } else {
                            session()->flash('importStudent' , "add new students successfully");
                            $user = new User();
                            $user->name = $value[0];
                            $user->email = $value[1];
                            $user->role = 4;
                            $user->password = bcrypt($value[1]);
                            $user->save();
                            $student = new Student();
                            $student->STUDENT_NAME = $value[0];
                            $student->FACULTY_ID = $request->faculty;
                            $student->DEPARTMENT_ID = $request->department;
                            $student->STUDENT_SSN = $value[1];
                            $student->STUDENT_PASSWORD = bcrypt($value[1]);
                          
                            $student->term = 1;
                            $student->semester = "2020 -2021";
                            $student->phone = "010";
                            $student->user_id = $user->id;
                            $student->save();
                        }

                    }

                }

                //if(!empty($arr)){
                //   Item::insert($arr);
                //}
            }
        } catch (\Exception $e) {
            Log::info($e);
            // return $e;
        }
        //dd($arr);
        
        return redirect()->route('students.index');
    }

    public function store(StudentRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return back()->withErrors(['error' => 'Email Found Before']);
        }
        //        dd($request->all());
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 4;
        $user->password = bcrypt($request->password);
        $user->save();
        $student = new Student();
        $student->STUDENT_NAME = $request->name;
        $student->FACULTY_ID = $request->faculty;
        $student->DEPARTMENT_ID = $request->department;
        $student->STUDENT_SSN = $request->snn;
        $student->STUDENT_PASSWORD = bcrypt($request->password);
        $student->STUDENT_EMAIL = $request->email;
        $student->term = $request->term;
        $student->semester = $request->year;
        $student->phone = $request->phone;
        $student->user_id = $user->id;
        $student->save();
        return redirect()->route('students.index');
    }//end of store

    public function update(StudentRequest $request, Student $student)
    {
        $user = $student->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = 4;
        $user->password = bcrypt($request->password);
        $user->save();
        $student->STUDENT_NAME = $request->name;
        $student->FACULTY_ID = $request->faculty;
        $student->DEPARTMENT_ID = $request->department;
        $student->STUDENT_SSN = $request->snn;
        $student->STUDENT_PASSWORD = bcrypt($request->password);
        $student->STUDENT_EMAIL = $request->email;
        $student->term = $request->term;
        $student->semester = $request->year;
        $student->phone = $request->phone;
        $student->user_id = $user->id;
        $student->save();
        return redirect()->route('students.index');

    }//end of update

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index');

    }//end of destroy

    public function getDepartment(Request $request)
    {
        $depart_select = '';
        if ($request->depart)
            $depart_select = $request->depart;
        $departments = Department::where('FACULTY_ID', $request->id)->get();
        $data = '<option> select department</option>';

        foreach ($departments as $department) {
            $data .= '<option ';
//            if($depart_select ==$department->id)
//                $data.= ' selected';
            $data .= ' value="' . $department->id . '">' . $department->DEPARTMENT_NAME . '</option>';
        }
        return $data;
    }
    public function getClass(Request $request)
    {
        $class_select = '';
        if ($request->class)
            $class_select = $request->class;
        $classes = DepartmentClass::where('DEPARTEMENT_ID', $request->id)->get();
        $data = '<option> select class</option>';

        foreach ($classes as $class) {
            $data .= '<option ';
//            if($depart_select ==$department->id)
//                $data.= ' selected';
            $data .= ' value="' . $class->id . '">' . $class->CLASS_NAME . '</option>';
        }
        return $data;
    }

    public function getStudents(Request $request)
    {
        $students = Student::where('DEPARTMENT_ID', $request->id)->get();
        $data = '';
//        dd($students);
        foreach ($students as $student) {
            $data .= '<tr class="gradeX" >
            <td>' . $student->STUDENT_NAME .
            '</td><td>' . $student->faculty->FACULTY_NAME .'</td ><td >' ;
             if($student->term == 1 )
                 $data .='First';
            else
                $data .='Second';
            $data .='</td ><td class="actions" >' .
                '<a href="#" class="on-default " data-toggle="modal"
                                   data-target="#con-close-modal_' . $student->id . '">
                                    <i style="color: white;padding: 8px 10px;background-color: #10c469 !important;border: 1px solid #10c469 !important;" class="fa fa-pencil"></i></a>'
                . '
                                <a href="#" data-toggle="modal" data-target="#dialog_' . $student->id . '"
                                   class="on-default ">
                                    <i style="color: white; background-color: #ff5b5b !important; border: 1px solid #ff5b5b !important;padding: 8px 10px;" class="fa fa-trash-o">
                                    </i>
                                </a></td >';
//            @include('admin.students.edit');
            $data .= $this->editform($student);
            $route = route('students.destroy', $student->id);
            $id = $student->id;
            $message = "Do You Want To Delete This Student ?";
            $data .= $this->deleteform($route, $id, $message);
//            @include('layouts.delete');
            $data .= '</tr>';
        }
        return $data;
    }

    public function editform($student)
    {
        $faculites = Faculty::all();


        $data = '
        <div id="con-close-modal_' . $student->id . '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Edit    Faculty </h4>
                    </div>
                    <form action="' . route('students.update', $student->id) . '" method="post" data-parsley-validate novalidate>

                    <div class="modal-body">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="userName"> Name*</label>
                                    <input type="text" value="' . $student->STUDENT_NAME . '" name="name" parsley-trigger="change" required placeholder="Enter  name" class="form-control" id="userName">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="emailAddress">Email address*</label>
                                    <input type="email" name="email" value="' . $student->STUDENT_EMAIL . '" parsley-trigger="change" required placeholder="Enter email" class="form-control" id="emailAddress">
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-lg-6">
                                    <label for="pass1">Password*</label>
                                    <input id="pass1" name="password" parsley-trigger="change" type="password" placeholder="Password"  required class="form-control">
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="sel1">Select Colleges *</label>
                                    <select  name="faculty" class="form-control select2" onchange="department_ajax(this.value)">
                                        <option value="">Select Faculty</option>';
        foreach ($faculites as $facu) {
            $data .= '<option ' . $student->FACULTY_ID == $facu->id ? "selected" : '' . 'value="' . $facu->id . '"> ' . $facu->FACULTY_NAME . '</option>';
        }
        $data .= '</select>
                                </div>
                            </div>
                            <div class="row">
                              ';
        $departments_select = \App\Department::where('FACULTY_ID', $student->FACULTY_ID)->get();


        $data .= '<div class="form-group col-lg-6">
            <label for="sel1">Select Departement *</label>
            <select name="department" class="form-control select2" id="depart">';
        foreach ($departments_select as $department) {
            $data .= '<option' . $student->DEPARTMENT_ID == $department->id ? "selected" : "" . 'value="' . $department->id . '"> ' . $department->DEPARTMENT_NAME . '</option>';

        }

        $data .= '</select>
        </div>
        <div class="form-group col-lg-6">
            <label for="sel1">Select Term *</label>
            <select name="term" class="form-control select2">';
        $data .= '<option ' . $student->term == 1 ? 'selected' : ' ' . ' value="1"> First</option>';
        $data .= '<option ' . $student->term == 2 ? 'selected' : ' ' . ' value="2">Second</option>';
        $data .= '</select>
        </div>
        </div>
        <div class="row">

            <div class="form-group col-lg-6">
                <label for="sel1">Select Year *</label>
                <select name="year" class="form-control select2">';
        $data .= '<option ' . $student->semester == '2020 -2021' ? "selected" : '' . ' value="2020 -2021"> 2020 -2021</option>';
        $data .= '<option ' . $student->semester == '2019 -2020' ? "selected" : '' . ' value="2019 -2020"> 2019 -2020</option>';
        $data .= '<option ' . $student->semester == '2018 -2019' ? "selected" : '' . ' value="2018 -2019"> 2018 -2019</option>';
        $data .= '<option ' . $student->semester == '2017 -2018' ? "selected" : '' . ' value="2017 -2018"> 2017 -2018</option>';

        $data .= '
                </select>
            </div>
            <div class="form-group col-lg-6 ">
                <label>Code</label>
                <input type="text" name="phone" placeholder="" value="' . $student->phone . '" class="form-control" data-parsley-id="10">
                <span class="font-13 text-muted"></span>
            </div>

        </div>
        <div class="row">
            <div class="form-group col-lg-6">
                <label for="userName"> SNN*</label>
                <input type="text" name="snn" parsley-trigger="change" value=""' . $student->STUDENT_SSN . '" required placeholder="Enter  SNN" class="form-control" id="userName">
            </div>
        </div>

        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info waves-effect waves-light">Edit </button>
        </div>
        </form>
        </div>
        </div>
        </div>';
        return $data;

    }

    public function deleteform($route, $id, $message)
    {
        $data = '
        <div id="dialog_' . $id . '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">';
        $data .= '<div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
    Warming
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center"><span style="color: red;"></span></h4>
            </div>
            <div class="modal-body">' .
            $message
            . '</div>
            <div style="clear: both"></div>
            <div class="modal-footer">
                <form action=' . $route . '" method="post" style="display: inline;">';
        echo csrf_field();
        echo method_field('delete');
        $data .= '<button type="submit" class="btn btn-primary">Yes</button>
                </form>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>

            </div>
        </div>

    </div>
</div><!-- /.modal -->';
        return $data;
    }

}
