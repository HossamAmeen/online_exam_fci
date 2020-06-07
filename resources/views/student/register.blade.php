<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <!-- App Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">

    <!-- App title -->
    <title> online Exam System</title>

    <!-- App CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/pages.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/menu.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="{{asset('assets/js/modernizr.min.js')}}"></script>

</head>

<body>

  <div class="container" style="background-color:white;">
      <div class="row text-center">
          <div class="col-md-8 col-md-offset-2">
            <div class="col-md-2">
              <img class="img-responsive logo-img" src="{{asset('assets/images/ic.jpg')}}">
            </div>
            <div class="col-md-8">
            <a href="{{ route('login')}}" class="logo"><span> <span>Online</span> Exam<span>System</span></span><i class="zmdi zmdi-layers"></i></a>
            </div>
            <div class="col-md-2">
              <img class="img-responsive logo-img" src="{{asset('assets/images/logo.png')}}">
            </div>

          </div>
      </div>
      <br/>
      <hr/>
      <br/>
      @if(isset($responsecode)&& $responsecode==1)
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading">Student Registeration Form</div>

                  <div class="panel-body">
                      <span>Congratulations, your registeration has beee completed successfuly.</span>
                      <span>You can login from <a href="{{route('login')}}">here</a>.</span>
                  </div>
              </div>
            </div>
      </div>
      @else
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-heading">Student Registeration Form</div>

                  <div class="panel-body">
                      <form class="form-horizontal" method="POST" action="{{ route('storestudent') }}" onsubmit="return validateRegisterationForm()">
                          {{ csrf_field() }}

                          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                              <label for="name" class="col-md-4 control-label">Name<span style="color:red;">*</span></label>

                              <div class="col-md-6">
                                  <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                  @if ($errors->has('name'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('name') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group{{ $errors->has('ssn') ? ' has-error' : '' }}">
                              <label for="name" class="col-md-4 control-label">SSN<span style="color:red;">*</span></label>

                              <div class="col-md-6">
                                  <input id="ssn" type="text" class="form-control" name="ssn" value="{{ old('ssn') }}" pattern="[0-9]{14}" title="14 digits SSN number" required autofocus>

                                  @if ($errors->has('ssn'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('ssn') }}</strong>
                                      </span>
                                  @endif
                              </div>
                              <div class="col-md-8" id="ssn-status">
                              </div>
                          </div>

                          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                              <label for="email" class="col-md-4 control-label">E-Mail Address<span style="color:red;">*</span></label>

                              <div class="col-md-6">
                                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" onchange="existmail_ajax(this.value)" required>

                                  @if ($errors->has('email'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('email') }}</strong>
                                      </span>
                                  @endif
                              </div>
                              <div class="col-md-8" id="email-status">
                              </div>
                          </div>

                          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                              <label for="password" class="col-md-4 control-label">Password<span style="color:red;">*</span></label>

                              <div class="col-md-6">
                                  <input id="password" type="password" class="form-control" name="password" required>

                                  @if ($errors->has('password'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="password-confirm" class="col-md-4 control-label">Confirm Password<span style="color:red;">*</span></label>

                              <div class="col-md-6">
                                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                              </div>
                              <div class="col-md-8" id="password-confirm-status">
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="sel1" class="col-md-4 control-label">Faculty <span style="color:red;">*</span></label>
                              <div class="col-md-6">
                                <select  id="faculty" name="faculty" class="form-control select2" onchange="department_ajax(this.value)">
                                  <option value="-1">Select Faculty</option>
                                  @foreach($faculites as $facu)
                                  <option value="{{$facu->id}}"> {{$facu->FACULTY_NAME}}</option>
                                  @endforeach
                              </select>
                              <div class="col-md-8" id="faculty-status">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                              <label for="sel1" class="col-md-4 control-label">Department</label>
                              <div class="col-md-6">
                                <select  name="department" class="form-control select2" id="depart" onchange="class_ajax(this.value)">

                                </select>
                            </div>
                          </div>
                          <div class="form-group">
                              <label for="sel1" class="col-md-4 control-label">Class</label>
                              <div class="col-md-6">
                                <select  name="class" class="form-control select2" id="class">

                              </select>
                            </div>
                          </div>
                          <div class="form-group{{ $errors->has('stage') ? ' has-error' : '' }}">
                              <label for="stage" class="col-md-4 control-label">Stage<span style="color:red;">*</span></label>

                              <div class="col-md-6">
                                  <input id="stage" type="text" class="form-control" name="stage" value="{{ old('stage') }}" required autofocus>

                                  @if ($errors->has('name'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('name') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-md-10 col-md-offset-2">

                                @if(isset($responsecode)&& $responsecode==2)
                                
                                  <span style="color:red;">- The email is already exist. Please, select another one.</span>
                                @endif
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-md-6 col-md-offset-6">
                                <button type="button" class="btn btn-primary">
                                  Clear
                                </button>
                                  <button type="submit" class="btn btn-primary" >
                                      Register
                                  </button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
      @endif
  </div>



<script>
    var resizefunc = [];
    function validateRegisterationForm()
    {
      var pass=document.getElementById("password").value;
      var passc=document.getElementById("password-confirm").value;
      alert('test');
      if(pass.localeCompare(passc)!=0)
      {
        document.getElementById("password-confirm-status").innerHTML='<span style="color:red;">Does not match the password</span>';
        alert('2');
        return false;
      }
      alert('3');


      var fac = document.getElementById("faculty");
      var facultyvalue = fac.options[fac.selectedIndex].value;
      alert(facultyvalue);
      if(facultyvalue==-1)
      {
        alert('4');
        document.getElementById("faculty-status").innerHTML='<span style="color:red;">Please, select the faculty</span>';

        return false;
      }

      return true;
    }
    function department_ajax(val) {
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '{{route('getDepartment')}}', //Your form processing file URL
            data: {id: val, _token: "{{csrf_token()}}"}, //Forms name
//              dataType  : 'json',
            success: function (data) {
      //alert(data)

                //$('#depart').select2('destroy')
                $('#depart').html(data)
                //$('#depart').select2()


            }
        });
    }
    function class_ajax(val) {

        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '{{route('getClass')}}', //Your form processing file URL
            data: {id: val, _token: "{{csrf_token()}}"}, //Forms name
//              dataType  : 'json',
            success: function (data) {
      //alert(data)
            alert(data)
                //$('#depart').select2('destroy')
                $('#class').html(data)
                //$('#depart').select2()


            }
        });
    }
    function existmail_ajax(val) {
        $.ajax({ //Process the form using $.ajax()
            type: 'POST', //Method type
            url: '{{route('existEmail')}}', //Your form processing file URL
            data: {email: val, _token: "{{csrf_token()}}"}, //Forms name
//              dataType  : 'json',
            success: function (data) {
      //alert(data)
                alert(data);
                //$('#depart').select2('destroy')
                if(data.localeCompare('yes')==0)
                {
                  $('#email-status').html('<span style="color:red">Exist email. Please, select another one.</span>')
                }
                //$('#depart').html(data)
                //$('#depart').select2()


            }
        });
    }
</script>

<!-- jQuery  -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/detect.js')}}"></script>
<script src="{{asset('assets/js/fastclick.js')}}"></script>
<script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('assets/js/jquery.blockUI.js')}}"></script>
<script src="{{asset('assets/js/waves.js')}}"></script>
<script src="{{asset('assets/js/wow.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('assets/js/jquery.scrollTo.min.js')}}"></script>

<!-- App js -->
<script src="{{asset('assets/js/jquery.core.js')}}"></script>
<script src="{{asset('assets/js/jquery.app.js')}}"></script>

</body>

</html>
