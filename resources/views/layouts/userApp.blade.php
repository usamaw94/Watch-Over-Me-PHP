<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="/userAssets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/userAssets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Watch Over Me - User
    </title>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="/userAssets/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="/userAssets/css/material-dashboard.min.css?v=2.1.2" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="/userAssets/demo/demo.css" rel="stylesheet" />
    <link href="/userAssets/css/custom.css" rel="stylesheet"/>

    @yield('styling')

</head>

<body>

    <div class="wrapper">

        @yield('content')

    </div>


<!--   Core JS Files   -->
<script src="/userAssets/js/core/jquery.min.js"></script>
<script src="/userAssets/js/core/popper.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="/userAssets/js/core/bootstrap-material-design.min.js"></script>

    <script src="/userAssets/js/core/jquery-ui.js"></script>
<script src="/userAssets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Plugin for the momentJs  -->
<script src="/userAssets/js/plugins/moment.min.js"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="/userAssets/js/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="/userAssets/js/plugins/arrive.min.js" type="text/javascript"></script>
<!--  Notifications Plugin    -->
<script src="/userAssets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/userAssets/js/material-dashboard.min.js" type="text/javascript"></script>

    @yield('script')

</body>

</html>
