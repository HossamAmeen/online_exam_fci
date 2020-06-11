<div id="sidebar-menu">
    @if(Auth::check())
    <ul>

        @if(auth()->user()->role==1)
            <li>
                <a href="{{route('doctor.index')}}" class="waves-effect"><i class="fa fa-user" aria-hidden="true"></i>
                    <span> Doctors </span> </a>
            </li>
            <li>
                <a href="{{route('studentAffairs.index')}}" class="waves-effect"><i class="fa fa-users"
                        aria-hidden="true"></i> <span> Students Affairs </span>
                </a>
            </li>
            <li>
                <a href="{{route('courses.index')}}" class="waves-effect"><i class="fa fa-book"
                        aria-hidden="true"></i><span> Courses </span>
                </a>
            </li>
            <li>
                <a href="{{route('students.index')}}" class="waves-effect"><i class="fa fa-users" aria-hidden="true"></i>
                    <span> Students </span> </a>
            </li>
            <li>
                <a href="{{route('faclities.index')}}" class="waves-effect"><i class="fa fa-user" aria-hidden="true"></i>
                    <span> Faculties </span> </a>
            </li>
            <li>
                <a href="{{route('departments.index')}}" class="waves-effect"><i class="fa fa-user" aria-hidden="true"></i>
                    <span> Departments </span>
                </a>
            </li>
            <li>
                <a href="{{route('IlosType.index')}}" class="waves-effect"><i class="fa fa-book"
                        aria-hidden="true"></i><span> Ilos Type </span> </a>
            </li>
            <li>
                <a href="{{route('ilos.index')}}" class="waves-effect"><i class="fa fa-book" aria-hidden="true"></i><span>
                        Ilos </span> </a>
            </li>
        @endif
        @if(auth()->user()->role==2)
            <li>
                <a href="{{route('doctorProfile.index')}}" class="waves-effect"><i class="fa fa-book"
                        aria-hidden="true"></i><span> Profile </span> </a>
            </li>
            <li>
                <a href="{{route('doctorProfile.exam.creates')}}" class="waves-effect"><i class="fa fa-book"
                        aria-hidden="true"></i><span> Create Exam </span> </a>
            </li>
            <li>
                <a href="{{route('doctorProfile.exam.result')}}" class="waves-effect"><i class="fa fa-book"
                        aria-hidden="true"></i><span> Exam Result </span> </a>
            </li>
            <li>
                <a href="{{route('doctorProfile.question.createBank')}}" class="waves-effect"><i class="fa fa-book"
                        aria-hidden="true"></i><span> Bank </span> </a>
            </li>
        @endif
        @if(auth()->user()->role==3)
            <li>
                <a href="{{route('students.index')}}" class="waves-effect"><i class="fa fa-users" aria-hidden="true"></i>
                    <span> Students </span> </a>

            </li>
            <li>
                <a href="{{route('studentCourses.index')}}" class="waves-effect"><i class="fa fa-users"
                        aria-hidden="true"></i>
                    <span> Register </span> </a>

            </li>
        @endif
        @if(auth()->user()->role==4)
            <li>
                <a href="{{route('student.index')}}" class="waves-effect"><i class="fa fa-users" aria-hidden="true"></i>
                    <span> Exams </span> </a>
            </li>
        @endif
        @if(auth()->user()->role==5)
        <li>
            <a href="{{route('new.student.index')}}" class="waves-effect"><i class="fa fa-users" aria-hidden="true"></i>
                <span> add new student </span> </a>
        </li>
       
        @endif


        {{--<li>--}}
        {{--<a href="{{route('questionType.index')}}" class="waves-effect"><i class="fa fa-book"
            aria-hidden="true"></i><span> Question Type </span> </a>--}}
        {{--</li>--}}

        {{--<li>--}}
        {{--<a href="{{route('semester.index')}}" class="waves-effect"><i class="fa fa-book"
            aria-hidden="true"></i><span> Semester </span> </a>--}}
        {{--</li>--}}


    </ul>
    <div class="clearfix"></div>
    @endif
</div>