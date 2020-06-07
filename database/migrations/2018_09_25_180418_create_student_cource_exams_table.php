<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentCourceExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_cource_exams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('STUDENT_ID');
            $table->integer('COURSE_ID');
            $table->integer('EXAM_ID')->nullable();
            $table->integer('SEMESTER_ID')->nullable();
            $table->double('Total_Student_Score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_cource_exams');
    }
}
