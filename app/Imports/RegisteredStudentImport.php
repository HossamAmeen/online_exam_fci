<?php

namespace App\Imports;
use App\User;
use App\Student;
use App\Course;
use App\Student_cource_exam;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
class RegisteredStudentImport implements ToModel , WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {

        $student = Student::where('STUDENT_SSN' , $row[1] )->first();
        $course = Course::find(request('course_id'));
        if($student === null){
            
            $user = new User();
                            $user->name =  $row[0];
                            $user->email = $row[1];
                            $user->role = 4;
                            $user->password = bcrypt($row[1]);
                            $user->save();

            $student =  Student::create([
                'STUDENT_NAME' => $row[0] , 
                'STUDENT_SSN'  => $row[1] ,
                'STUDENT_PASSWORD' => bcrypt($row[1]) , 
                'FACULTY_ID' => request('faculty'),
                'DEPARTMENT_ID' =>$course->DEPARTMENT_ID,
                'term' => 2 ,
                'semester'=>'2019 -2020',
                'phone'=>"01",
                'user_id' => $user->id
            ]);
            session()->flash('addStudent', 'add new student successfully');
        }
        if(! Student_cource_exam::where('STUDENT_ID' , $student->id)->where('COURSE_ID' , request('course_id'))->first() )
        {
            session()->flash('status', 'The file was uploaded successfully');
            Student_cource_exam::create([ 
                'STUDENT_ID' => $student->id ,
                "COURSE_ID"  =>request('course_id') ,
            ]);
        }
        // else
        // session()->flash('status', 'The file was uploaded successfully');

    
    }
    public function startRow(): int
    {
        return 2;
    }
}
