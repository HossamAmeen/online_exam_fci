<?php

namespace App\Exports;

use App\Stud_ques_ans_choice;
use App\StudentExam;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResultExcel implements FromCollection , WithHeadings ,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }


    public function collection()
    {
        
        return StudentExam::with(['exam' , 'student'])->where('exam_id',$this->id)->get();
       
        
    }
    public function headings(): array

    {

        return [
            'exam',
            'student',
            'department',
            'result',
            'date',
        ];

    }

    public function map($result) : array {

        return [
        
            $result->exam->EXAM_NAME,
            $result->student->STUDENT_NAME,
            $result->student->department->DEPARTMENT_NAME,
            $result->result,
            $result->updated_at ,
        ] ;

 

 

    }
}
