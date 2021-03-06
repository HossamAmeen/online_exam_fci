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
    <title>نظام جامعة اسيوط للامتحانات الإلكترونية</title>

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

<body style="background-color: rgb(116, 128, 139)">

<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="text-center">
        <a href="#" class="logo">
            <span >  
                <span >نظام جامعة اسيوط للامتحانات الإلكترونية</span><i class="zmdi zmdi-layers"></i></span>
        </a>

    </div>
    <div class="m-t-40 card-box">
        <div class="text-center">
            <h4 class="text-uppercase font-bold m-b-0"> <span  class="logo"> تسجيل الدخول </span></h4>
        </div>
        <div class="panel-body">
            <form class="form-horizontal m-t-20" method="post" action="{{ route('login') }}">
                {!! csrf_field()  !!}
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" name="email" type="text" required="" placeholder="اسم المستخدم">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" name="password" type="password" required="" placeholder="كلمة المرور">
                    </div>
                </div>

                {{--<div class="form-group ">--}}
                    {{--<div class="col-xs-12">--}}
                        {{--<div class="checkbox checkbox-custom">--}}
                            {{--<input id="checkbox-signup" type="checkbox">--}}
                            {{--<label for="checkbox-signup">--}}
                                {{--Remember me--}}
                            {{--</label>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}

                <div class="form-group text-center m-t-30">
                    <div class="col-xs-12">
                        <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light" type="submit">دخول</button>
                    </div>
                </div>

            </form>

        </div>
    </div>
    <!-- end card-box-->


</div>
<!-- end wrapper page -->



<script>
    var resizefunc = [];
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