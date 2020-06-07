    <table class="table table-striped" id="faculty">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>StudentName</th>
                                <th>Exam</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Student_cource_exams as $k=>$Student_cource_exam )
                            <tr class="gradeX">
                                <th>{{$Student_cource_exam->course->COURSE_NAME ?? ""}}</th>
                                @if(isset($Student_cource_exam->student))
                                <th> {{$Student_cource_exam->student->STUDENT_NAME}}</th>
                                @else
                                <th></th>
                                @endif
                                <th>{{$Student_cource_exam->Total_Student_Score}}</th>
                                <th class="actions">

                                    <a href="#" data-toggle="modal" data-target="#dialog_{{$Student_cource_exam->id}}"
                                        class="on-default ">
                                        <i style="color: white; background-color: #ff5b5b !important; border: 1px solid #ff5b5b !important;padding: 8px 10px;"
                                            class="fa fa-trash-o">
                                        </i>
                                    </a>
                                    <!-- <a  class="on-default btn-info"  > <i class="fa fa-keyboard-o"></i> </a> -->
                                </th>

                                <?php
                                    $route=route('ilos.destroy', $Student_cource_exam->id);
                                    $id= $Student_cource_exam->id;
                                    $message="Do You Want To Delete This Registeration ?";
                                    ?>
                                @include('layouts.delete')
                            </tr>
                            @endforeach


                        </tbody>
                    </table>