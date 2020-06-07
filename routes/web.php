<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/registerstudent','admin\StudentsController@registerStudent')->name('registerstudent');
Route::post('/storestudent','admin\StudentsController@storeStudent')->name('storestudent');
Route::post('/getdepartment', 'admin\StudentsController@getDepartment')->name('getDepartment');
Route::post('/getclass', 'admin\StudentsController@getClass')->name('getClass');
Route::post('/existemail', 'admin\StudentsController@existEmail')->name('existEmail');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {

    Route::prefix('courses')->group(function () {

        Route::get('/', 'admin\CoursesController@index')->name('courses.index');

        Route::get('/create', 'admin\CoursesController@create')->name('courses.create');

        Route::post('/store', 'admin\CoursesController@store')->name('courses.store');

        Route::get('/{course}/show', 'admin\CoursesController@show')->name('courses.show');

        Route::get('/{course}/edit', 'admin\CoursesController@edit')->name('courses.edit');

        Route::post('/{course}/update', 'admin\CoursesController@update')->name('courses.update');

        Route::delete('/{course}/destroy', 'admin\CoursesController@destroy')->name('courses.destroy');



		Route::get('course/{course_id}',array(
                'as'=>'admin.courses.show',
                'uses'=>'admin\CoursesController@show'
                ));

    });

    Route::prefix('faclities')->group(function () {

        Route::get('/', 'admin\FaclitiesController@index')->name('faclities.index');

        Route::get('/create', 'admin\FaclitiesController@create')->name('faclities.create');

        Route::post('/store', 'admin\FaclitiesController@store')->name('faclities.store');

        Route::get('/{faculty}/show', 'admin\FaclitiesController@show')->name('faclities.show');

        Route::get('/{faculty}/edit', 'admin\FaclitiesController@edit')->name('faclities.edit');

        Route::put('/{faculty}/update', 'admin\FaclitiesController@update')->name('faclities.update');

        Route::delete('/{faculty}/destroy', 'admin\FaclitiesController@destroy')->name('faclities.destroy');
    });
    Route::prefix('departments')->group(function () {

        Route::get('/', 'admin\DepartmentsController@index')->name('departments.index');

        Route::get('/create', 'admin\DepartmentsController@create')->name('departments.create');

        Route::post('/store', 'admin\DepartmentsController@store')->name('departments.store');

        Route::get('/{department}/show', 'admin\DepartmentsController@show')->name('departments.show');

        Route::get('/{department}/edit', 'admin\DepartmentsController@edit')->name('departments.edit');

        Route::put('/{department}/update', 'admin\DepartmentsController@update')->name('departments.update');

        Route::delete('/{department}/destroy', 'admin\DepartmentsController@destroy')->name('departments.destroy');
    });
//    Route::prefix( 'students' )->group( function () {
//
//        Route::get( '/', 'admin\StudentsController@index' )->name( 'students.index' );
//
//        Route::get( '/create', 'admin\StudentsController@create' )->name( 'students.create' );
//
//        Route::post( '/store', 'admin\StudentsController@store' )->name( 'students.store' );
//
//        Route::get( '/{student}/show', 'admin\StudentsController@show' )->name( 'students.show' );
//
//        Route::get( '/{student}/edit', 'admin\StudentsController@edit' )->name( 'students.edit' );
//
//        Route::put( '/{student}/update', 'admin\StudentsController@update' )->name( 'students.update' );
//
//        Route::delete( '/{student}/destroy', 'admin\StudentsController@destroy' )->name( 'students.destroy' );
//
//        Route::post( '/get/department', 'admin\StudentsController@getDepartment' )->name( 'students.getDepartment' );
//    } );
    Route::prefix('IlosType')->group(function () {

        Route::get('/', 'admin\IlosTypeController@index')->name('IlosType.index');

        Route::get('/create', 'admin\IlosTypeController@create')->name('IlosType.create');

        Route::post('/store', 'admin\IlosTypeController@store')->name('IlosType.store');

        Route::get('/{ilosType}/show', 'admin\IlosTypeController@show')->name('IlosType.show');

        Route::get('/{ilosType}/edit', 'admin\IlosTypeController@edit')->name('IlosType.edit');

        Route::put('/{ilosType}/update', 'admin\IlosTypeController@update')->name('IlosType.update');

        Route::delete('/{ilosType}/destroy', 'admin\IlosTypeController@destroy')->name('IlosType.destroy');
    });
    Route::prefix('ilos')->group(function () {

        Route::get('/', 'admin\IlosController@index')->name('ilos.index');

        Route::get('/create', 'admin\IlosController@create')->name('ilos.create');

        Route::post('/store', 'admin\IlosController@store')->name('ilos.store');

        Route::get('/{ilos}/show', 'admin\IlosController@show')->name('ilos.show');

        Route::get('/{ilos}/edit', 'admin\IlosController@edit')->name('ilos.edit');

        Route::put('/{ilos}/update', 'admin\IlosController@update')->name('ilos.update');

        Route::delete('/{ilos}/destroy', 'admin\IlosController@destroy')->name('ilos.destroy');

        Route::post('/courses', 'admin\IlosController@courses')->name('ilos.getCourses');

    });

    Route::prefix('questionType')->group(function () {

        Route::get('/', 'admin\QuestionTypeController@index')->name('questionType.index');

        Route::get('/create', 'admin\QuestionTypeController@create')->name('questionType.create');

        Route::post('/store', 'admin\QuestionTypeController@store')->name('questionType.store');

        Route::get('/{quetype}/show', 'admin\QuestionTypeController@show')->name('questionType.show');

        Route::get('/{quetype}/edit', 'admin\QuestionTypeController@edit')->name('questionType.edit');

        Route::put('/{quetype}/update', 'admin\QuestionTypeController@update')->name('questionType.update');

        Route::delete('/{quetype}/destroy', 'admin\QuestionTypeController@destroy')->name('questionType.destroy');
    });
    Route::prefix('semester')->group(function () {

        Route::get('/', 'admin\SemesterController@index')->name('semester.index');

        Route::get('/create', 'admin\SemesterController@create')->name('semester.create');

        Route::post('/store', 'admin\SemesterController@store')->name('semester.store');

        Route::get('/{semester}/show', 'admin\SemesterController@show')->name('semester.show');

        Route::get('/{semester}/edit', 'admin\SemesterController@edit')->name('semester.edit');

        Route::put('/{semester}/update', 'admin\SemesterController@update')->name('semester.update');

        Route::delete('/{semester}/destroy', 'admin\SemesterController@destroy')->name('semester.destroy');
    });
    Route::prefix('doctor')->group(function () {

        Route::get('/', 'admin\DoctorController@index')->name('doctor.index');

        Route::get('/create', 'admin\DoctorController@create')->name('doctor.create');

        Route::post('/store', 'admin\DoctorController@store')->name('doctor.store');

        Route::get('/{doctor}/show', 'admin\DoctorController@show')->name('doctor.show');

        Route::get('/{doctor}/edit', 'admin\DoctorController@edit')->name('doctor.edit');

        Route::put('/{doctor}/update', 'admin\DoctorController@update')->name('doctor.update');

        Route::delete('/{doctor}/destroy', 'admin\DoctorController@destroy')->name('doctor.destroy');

        Route::post('/getCourses', 'admin\DoctorController@getCourses')->name('doctor.getCourses');


    });
    Route::prefix('student-affairs')->group(function () {

        Route::get('/', 'admin\StudentAffairsController@index')->name('studentAffairs.index');

        Route::get('/create', 'admin\StudentAffairsController@create')->name('studentAffairs.create');

        Route::post('/store', 'admin\StudentAffairsController@store')->name('studentAffairs.store');

        Route::get('/{sa}/show', 'admin\StudentAffairsController@show')->name('studentAffairs.show');

        Route::get('/{sa}/edit', 'admin\StudentAffairsController@edit')->name('studentAffairs.edit');

        Route::put('/{sa}/update', 'admin\StudentAffairsController@update')->name('studentAffairs.update');

        Route::delete('/{sa}/destroy', 'admin\StudentAffairsController@destroy')->name('studentAffairs.destroy');

    });
});
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'studentaffairadmin']], function () {


    Route::prefix('students')->group(function () {

        Route::get('/', 'admin\StudentsController@index')->name('students.index');

        Route::get('/create', 'admin\StudentsController@create')->name('students.create');

        Route::post('/store', 'admin\StudentsController@store')->name('students.store');

        Route::get('/{student}/show', 'admin\StudentsController@show')->name('students.show');

        Route::get('/{student}/edit', 'admin\StudentsController@edit')->name('students.edit');

        Route::put('/{student}/update', 'admin\StudentsController@update')->name('students.update');

        Route::delete('/{student}/destroy', 'admin\StudentsController@destroy')->name('students.destroy');

        Route::post('/get/department', 'admin\StudentsController@getDepartment')->name('students.getDepartment');
        Route::any('/get/students', 'admin\StudentsController@getStudentIndex')->name('students.getStudentIndex');


        Route::post('/import', 'admin\StudentsController@importExcel')->name('students.import');

    });
    Route::prefix('student-courses')->group(function () {

        Route::get('/', 'admin\StudentCourseController@index')->name('studentCourses.index');

        Route::get('/create', 'admin\StudentCourseController@create')->name('studentCourses.create');

        Route::post('/store', 'admin\StudentCourseController@store')->name('studentCourses.store');

        Route::get('/{studentCourse}/show', 'admin\StudentCourseController@show')->name('studentCourses.show');

        Route::get('/{studentCourse}/edit', 'admin\StudentCourseController@edit')->name('studentCourses.edit');

        Route::put('/{studentCourse}/update', 'admin\StudentCourseController@update')->name('studentCourses.update');

        Route::delete('/{studentCourse}/destroy', 'admin\StudentCourseController@destroy')->name('studentCourses.destroy');

        Route::post('/courses', 'admin\StudentCourseController@courses')->name('studentCourses.getCourses');
        Route::get('/get-courses', 'admin\StudentCourseController@getCourses')->name('studentCourses.getCoursesSelect');
		Route::post('/students', 'admin\StudentCourseController@students')->name('studentCourses.getStudent');
        Route::post('/import', 'admin\StudentCourseController@import')->name('studentsCourse.import');
		Route::get('/loadregisterations', 'admin\StudentCourseController@loadRegisterations')->name('studentCourses.loadregisterations');//// for select input in import excel sheet
        
    });
});
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'doctor']], function () {
    Route::prefix('doctor-profile')->group(function () {

        Route::get('/', 'admin\DoctorProfileContoller@index')->name('doctorProfile.index');
        Route::get('/exam/create', 'admin\DoctorProfileContoller@createExam')->name('doctorProfile.exam.creates');
        Route::post('/exam/create', 'admin\DoctorProfileContoller@storeExam')->name('doctorProfile.exam.store');
        Route::get('/question/create/{exam}', 'admin\DoctorProfileContoller@createQuestion')->name('doctorProfile.question.create');

        Route::get('/random-question/{exam_id}/{course_id}',array(
                'as'=>'doctorProfile.random_question_bank',
                'uses'=>'admin\DoctorProfileContoller@createRandomQuestion'
        ));
        Route::post('/question/store', 'admin\DoctorProfileContoller@storeQuestion')->name('doctorProfile.question.store');

        Route::get('/question/delete/{question}/{exam}', 'admin\DoctorProfileContoller@deleteQuestion')->name('doctorProfile.question.question');
        Route::get('/question/edit/{question}/{exam}', 'admin\DoctorProfileContoller@editQuestion')->name('doctorProfile.question.edit');
        Route::post('/question/update/{question}', 'admin\DoctorProfileContoller@updateQuestion')->name('doctorProfile.question.update');
        Route::post('/question/excel', 'admin\DoctorProfileContoller@uploadQuestionExcel')->name('doctorProfile.question.excel');

        Route::get('/exam/students', 'admin\DoctorProfileContoller@showExamResult')->name('doctorProfile.exam.result');
        Route::post('/exam/students', 'admin\DoctorProfileContoller@showExamResultDetial')->name('doctorProfile.exam.result');
        Route::get('/exam/export/{exam}', 'admin\DoctorProfileContoller@downloadResult')->name('doctorProfile.exam.result.downloadResult');


        Route::get('/exam/questions/{exam}/{student}/{course}', 'admin\DoctorProfileContoller@showExamQuestion')->name('doctorProfile.exam.question');
        Route::get('/exam/studentimages/{exam}/{student}', 'admin\DoctorProfileContoller@showExamStudentImages')->name('doctorProfile.exam.studentimages');
        Route::get('/exam/downloadPDF/{exam}/{student}/{course}', 'admin\DoctorProfileContoller@downloadStudentExamPDF')->name('doctorProfile.exam.downloadpdf');
        Route::get('/exam/downloadPDF/{exam}', 'admin\DoctorProfileContoller@downloadAllStudentsExamPDF')->name('doctorProfile.exam.downloadallpdf');

        Route::post('/exam/questions', 'admin\DoctorProfileContoller@storeGradeQuestion')->name('doctorProfile.post.question');
        Route::get('/exam/show/{exam}', 'admin\DoctorProfileContoller@showExam')->name('doctorProfile.show.exam');
        Route::get('/exam/print/{exam}', 'admin\DoctorProfileContoller@printExam')->name('doctorProfile.print.exam');

        Route::get('/exam/printhardnessreport/{exam}', 'admin\DoctorProfileContoller@printExamHardnessReport')->name('doctorProfile.print.examhardnessreport');
        Route::get('/exam/printilosreport/{exam}', 'admin\DoctorProfileContoller@printExamIlosReport')->name('doctorProfile.print.examilosreport');
        Route::get('/exam/printhardnessreportPDF/{exam}', 'admin\DoctorProfileContoller@printExamHardnessReportPDF')->name('doctorProfile.print.examhardnessreportpdf');
        Route::get('/exam/printilosreportPDF/{exam}', 'admin\DoctorProfileContoller@printExamIlosReportPDF')->name('doctorProfile.print.examilosreportpdf');

        Route::get('/exam/edit/{exam}', 'admin\DoctorProfileContoller@editExam')->name('doctorProfile.edit.exam');
        Route::post('/exam/update/{exam}', 'admin\DoctorProfileContoller@updateExam')->name('doctorProfile.exam.update');

        Route::get('/exam/calcuate/{exam}', 'admin\DoctorProfileContoller@calculateExam')->name('doctorProfile.calculate.exam');
        Route::get('/exam/reopen/{exam}', 'admin\DoctorProfileContoller@reopen')->name('doctorProfile.reopen.exam');
        Route::get('/exam/reopen/exam/{studentExam}', 'admin\DoctorProfileContoller@reopenExam')->name('doctorProfile.exam.reoprn.exam');
        Route::get('/exam/ilosresult/{exam}', 'admin\DoctorProfileContoller@ilosresult')->name('doctorProfile.ilosresult.exam');


    Route::get('/question/bank', 'admin\DoctorProfileContoller@createBankQuestion')->name('doctorProfile.question.createBank');

        Route::post('/question/bank', 'admin\DoctorProfileContoller@StoreBankQuestion')->name('doctorProfile.question.storeBank');
        Route::get('/bank/delete/{question}', 'admin\DoctorProfileContoller@deleteBankQuestion')->name('doctorProfile.delete.bank');

        Route::get('/back', function (){
            return back();
        })->name('back');


    });
});

Route::group(['prefix' => '/student', 'middleware' => ['auth', 'student','history']], function () {
    Route::prefix('exams')->group(function () {
        Route::get('/', 'admin\StudentExamsController@index')->name('student.index');
        Route::any('/start/{exam}', 'admin\StudentExamsController@startExam')->name('student.exam.start');
        Route::post('/answer/{exam}', 'admin\StudentExamsController@answerExam')->name('student.exam.answer');
        Route::post('/answer/ajax/{exam}', 'admin\StudentExamsController@answerExamAjax')->name('student.exam.answerAjax');

        Route::get('/result/{exam}', 'admin\StudentExamsController@resultExam')->name('student.exam.result');
        Route::get('/time', 'admin\StudentExamsController@time')->name('student.time');
        Route::post('/time', 'admin\StudentExamsController@timeSave')->name('student.time.save');



    });
});
Route::post('/uploadcamimage/{exam}', 'admin\StudentExamsController@uploadStudentExamImage')->name('student.exam.camimage');
