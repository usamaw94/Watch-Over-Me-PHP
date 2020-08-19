@extends('layouts.adminApp')

@section('styling')

@endsection

@section('content')
    <div class="sidebar" data-color="white" data-active-color="danger">
        <div class="logo">
            <a href="/admin" class="simple-text logo-mini">
                <!-- <div class="logo-image-small">
                  <img src="./assets/img/logo-small.png">
                </div> -->
                <!-- <p>CT</p> -->
            </a>
            <a href="/admin" class="simple-text logo-normal">
                Watch Over Me
                <!-- <div class="logo-image-big">
                  <img src="../assets/img/logo-big.png">
                </div> -->
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li>
                    <a href="#">
                        <i class="nc-icon nc-single-02"></i>
                        <p id="userId">{{ Auth::user()->id }}</p>
                    </a>
                </li>
                <li class="active ">
                    <a href="/admin">
                        <i class="nc-icon nc-bank"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li>
                    <a href="/adminServices">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>Services</p>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class="nc-icon nc-single-02"></i>
                        <p>People</p>
                    </a>
                </li>
                <li>
                    <a href="/adminLogout">
                        <i class="nc-icon nc-button-power"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>


    <div class="main-panel" style="height: 100vh;">


        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-icon btn-round">
                            <i class="nc-icon nc-minimal-right text-center visible-on-sidebar-mini"></i>
                            <i class="nc-icon nc-minimal-left text-center visible-on-sidebar-regular"></i>
                        </button>
                    </div>
                    <div class="navbar-toggle">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                    </div>
                    <a class="navbar-brand" href="javascript:;">Admin</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                    <span class="navbar-toggler-bar navbar-kebab"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navigation">
                    <ul class="navbar-nav">
                        <li class="nav-item btn-rotate dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="nc-icon nc-bell-55"></i>
                                <p>
                                    <span class="d-lg-none d-md-block">Show notification</span>
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right notification-panel" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item notification-panel-item" href="#">
                                    <div class="timeline-panel">
                                        <div class="timeline-body">
                                            <span class="badge badge-pill badge-danger">Help me request</span> &nbsp; <p>14:24:09 - 27/12/2019</p><br>
                                            <p>Service Id: <b>WOMSVC001</b></p><br>
                                            <p>Wearer: <b class="font-weight-bold text-uppercase">Usama Waheed</b> - <span>WOMUSR001</span></p>
                                        </div>
                                    </div>
                                </a>

                                <a class="dropdown-item notification-panel-item" href="#">
                                    <div class="timeline-panel">
                                        <div class="timeline-body">
                                            <span class="badge badge-pill badge-danger">Help me request</span> &nbsp; <p>14:24:09 - 27/12/2019</p><br>
                                            <p>Service Id: <b>WOMSVC001</b></p><br>
                                            <p>Wearer: <b class="font-weight-bold text-uppercase">Usama Waheed</b> - <span>WOMUSR001</span></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->


        <div class="content">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-settings-gear-65 text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">WOM</p>
                                        <p class="card-title">Services<p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <a href="/adminServices" class="stats">
                                <i class="fa fa-eye"></i>
                                View
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-single-02 text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">WOM</p>
                                        <p class="card-title">People<p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <a href="#" class="stats">
                                <i class="fa fa-eye"></i>
                                View
                            </a>
                        </div>
                    </div>
                </div>
                <div class="btn btn-default" onclick="showNotification('top','right')">Show Notification</div>
            </div>
        </div>


        <footer class="footer" style="position: absolute; bottom: 0; width: -webkit-fill-available;">
            <div class="container-fluid">
                <div class="row">
                    <div class="credits ml-auto">
              <span class="copyright">
                Watch Over Me
              </span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection

@section('script')

    <script>

        window.Echo.channel('notifyAlertLog.'+$('#userId').text())
            .listen('NewAlertLog', (e) => {

                alert("notification received");

                console.log(e);

                $.notify({
                    icon: "nc-icon nc-bell-55",
                    message: "Wearer: <b>"+ e.wearerName +"</b> needs your help.</br>" +
                        "Service ID: <b>"+ e.serviceId +"<b><br>" +
                        "Created at: "+ e.created_at +"<br>" +
                        "<b>Click this dialogue to respond</b>",
                    url: "https://www.google.com/",

                }, {
                    type: 'danger',
                    timer: 5000,
                    placement: {
                        from: 'top',
                        align: 'right'
                    }
                });

                // $( "#logsContainer" ).load(window.location.href + " #logsContent", function () {
                //
                //     var index = localStorage.getItem("activeLogId");
                //
                //     var id  = "#"+index;
                //
                //     $(id).addClass("logs-active");
                //
                // });


            });

    </script>

    <script>
        function showNotification(from, align) {
            color = 'danger';

            $.notify({
                icon: "nc-icon nc-bell-55",
                message: "Wearer: <b>Usama Waheed</b> needs your help.</br>" +
                    "Service ID: <b>WOM001<b><br>" +
                    "Created at: 01/02/2020 - 14:00<br>" +
                    "<b>Click this dialogue to respond</b>",
                url: "https://www.google.com/",

            }, {
                type: color,
                timer: 5000,
                placement: {
                    from: from,
                    align: align
                }
            });
        }
    </script>

@endsection


