<?php

namespace App\Exports;

use App\Stud_ques_ans_choice;
use App\StudentExam;
use Maatwebsite\Excel\Concerns\FromCollection;

class Result implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

    }
}
