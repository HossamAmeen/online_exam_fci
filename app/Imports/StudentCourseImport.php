<?php

namespace App\Imports;

use App\Student_cource_exam;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentCourseImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student_cource_exam([
            //
        ]);
    }
}
