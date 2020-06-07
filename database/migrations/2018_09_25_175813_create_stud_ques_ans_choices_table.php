<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudQuesAnsChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stud_ques_ans_choices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id');
            $table->text('choice');
            $table->integer('student_id');
            $table->integer('exam_id');
            $table->float('point');
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
        Schema::dropIfExists('stud_ques_ans_choices');
    }
}
