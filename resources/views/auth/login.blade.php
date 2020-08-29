<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/userAssets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/userAssets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Watch Over Me - User Panel
    </title>

    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="/userAssets/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="/userAssets/css/material-dashboard.min.css" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="/userAssets/demo/demo.css" rel="stylesheet" />

</head>

<body class="off-canvas-sidebar">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">Watch Over Me</a>
        </div>
    </div>
</nav>
<!-- End Navbar -->
<div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('/userAssets/img/login.jpg'); background-size: cover; background-position: top center;">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                    <form id="loginForm" class="form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="card card-login card-hidden">
                            <div class="card-header card-header-primary text-center">
                                <h4 class="card-title">User Log In</h4>
                            </div>
                            <div class="card-body ">
                                <p class="card-description text-center">Enter your email and password</p>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">email</i>
                                            </span>
                                        </div>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Email...">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{!! $message !!}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </span>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password..." autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </span>
                            </div>
                            <div class="card-footer justify-content-center">
                                <button type="submit" class="btn btn-primary btn-link btn-lg">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--   Core JS Files   -->
<script src="/userAssets/js/core/jquery.min.js"></script>
<script src="/userAssets/js/core/popper.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
{{--<script src="/webAssets/js/core/bootstrap-material-design.min.js"></script>--}}
<script src="/userAssets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Forms Validations Plugin -->
<script src="/userAssets/js/plugins/jquery.validate.min.js"></script>
<!-- Place this tag in your head or just before your close body tag. -->
<script src="/userAssets/js/buttons.js"></script>
<!--  Notifications Plugin    -->
<script src="/userAssets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/userAssets/js/material-dashboard.min.js" type="text/javascript"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="/userAssets/demo/demo.js"></script>
<script>
    $(document).ready(function() {
        md.checkFullPageBackgroundImage();
        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700);

        var $validator = $('#loginForm').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                }
            },

            highlight: function(element) {
                $(element).closest('.input-group').removeClass('has-success').addClass('has-danger');
            },
            success: function(element) {
                $(element).closest('.input-group').removeClass('has-danger').addClass('has-success');
            },
            errorPlacement : function(error, element) {
                $(element).append(error);
            }
        });

    });

</script>
</body>


</html>
