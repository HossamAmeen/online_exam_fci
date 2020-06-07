<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->text('STUDENT_NAME')->nullable();
            $table->integer('FACULTY_ID')->nullable();
            $table->integer('DEPARTMENT_ID')->nullable();
            $table->text('STUDENT_SSN')->nullable();
            $table->text('STUDENT_PASSWORD')->nullable();
            $table->text('STUDENT_EMAIL')->nullable();
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
        Schema::dropIfExists('students');
    }
}
