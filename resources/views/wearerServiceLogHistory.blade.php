@extends('layouts.userApp')

@section('styling')

@endsection

@section('content')

    <div class="sidebar" data-color="rose" data-background-color="black" data-image="/userAssets/img/sidebar-1.jpg">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

          Tip 2: you can also add an image using data-image tag
      -->
        <div class="logo">
            <a href="#" class="simple-text logo-mini">
                WOM
            </a>
            <a href="/home" class="simple-text logo-normal">
                Watch Over Me
            </a></div>

        <div class="sidebar-wrapper">
            <div class="user">
                <div class="photo">
                    <img src="/userAssets/img/default-avatar.png" />
                </div>
                <div class="user-info">
                    <a data-toggle="collapse" href="#collapseExample" class="username">
              <span id="userCredentials" data-id="{{ Auth::user()->person_id }}">
                {{ Auth::user()->full_name }}
                <b class="caret"></b>
              </span>
                    </a>
                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="sidebar-mini"> MP </span>
                                    <span class="sidebar-normal"> My Profile </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="sidebar-mini"> EP </span>
                                    <span class="sidebar-normal"> Edit Profile </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/userLogout">
                                    <span class="sidebar-mini"> LG </span>
                                    <span class="sidebar-normal"> Logout </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="/home">
                        <i class="material-icons">dashboard</i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/userAsWearer">
                        <i class="material-icons">settings</i>
                        <p> As wearer </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/userAsWatcher">
                        <i class="material-icons">settings</i>
                        <p> As watcher </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/userAsCustomer">
                        <i class="material-icons">settings</i>
                        <p> As customer </p>
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <div class="main-panel">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                            <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <a class="navbar-brand" href="javascript:;">Service Logs</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div id="notificationContainer" class="collapse navbar-collapse justify-content-end">

                    <div id="reloadNotification">

                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" data-target="#notificationDropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">notifications</i>
                                    @if($aNCount != 0)
                                        <span class="notification">{{ $aNCount }}</span>
                                    @endif
                                    <p class="d-lg-none d-md-block">
                                        Some Actions
                                    </p>
                                </a>
                                <div id="notificationDropdown" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    @if($aNCount == 0)

                                        <p class="no-space description"> &nbsp; No new notifications</p>

                                    @else

                                        @foreach($alertNotifications as $aN)

                                            <a class="dropdown-item notification-panel-item" target="_blank" href="{{ $aN->responding_link }}">
                                                <div class="timeline-panel">
                                                    <div class="timeline-body">
                                                        <p><span class="badge badge-pill badge-danger">Help me request</span></p>
                                                        <p>{{ $aN->alert_log_time }} - {{ $aN->alert_log_date }}</p>
                                                        <p>Service Id: <b>{{ $aN->service_id }}</b></p>
                                                        <p>Wearer: <b class="font-weight-bold text-uppercase">{{ $aN->wearer_name }}</b></p>
                                                    </div>
                                                </div>
                                            </a>

                                        @endforeach

                                    @endif
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="content">
            <div class="container-fluid">

                <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header ">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h5>Service ID: {{ $serviceDetails->service_id }}</h5>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="pull-right">
                                            <h5><span class="font-weight-normal">Wearer: </span>{{ $wearerDetails->full_name }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 style="font-size: 18px">
                                            @if($date == '' && $type == '')
                                                Showing all logs
                                            @endif

                                            @if($date != '' && $type != '')
                                                Showing all <b>{{ $type }}s</b> for <b>{{ $date }}</b>
                                            @endif

                                            @if($date != '' && $type == '')
                                                Showing all logs for <b>{{ $date }}</b>
                                            @endif

                                            @if($date == '' && $type != '')
                                                Showing all <b>{{ $type }}s</b>
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="col-md-4">
                                        <button data-toggle="modal" data-target="#logFilters" class="btn btn-outline-primary btn-block">
                                            Apply Search Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="card ">
                            <div class="card-header card-header-text card-header-info">
                                <div class="card-text">
                                    <h4 class="card-title">Wearer location</h4>
                                    <p class="card-category">
                                        <!--                        <i class="no-space fa fa-map-marker"></i>-->
                                        <span id="wearerLogLocality"></span>
                                    </p>
                                </div>
                            </div>
                            <div class="card-body ">
                                <h4 class="card-title"></h4>
                                <div id="googleMap" class="map"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h5>Logs</h5>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="pull-right">
                                            <span>Showing {{($logs->currentPage()-1)* $logs->perPage() + 1}} to
                                                {{ ($logs->currentPage()-1)* $logs->perPage() + $logs->perPage() }}
                                                of {{ $logs->total() }} logs</span><br>
                                            <div class="text-right">
                                                <button type="button" rel="tooltip" title="Previous" class="btn btn-white btn-link btn-sm">
                                                    <i class="fa fa-angle-left"></i>
                                                </button>
                                                <button type="button" rel="tooltip" title="Next" class="btn btn-white btn-link btn-sm">
                                                    <i class="fa fa-angle-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body logs-container">
                                <table class="table table-hover">
                                    <tbody>

                                    <tr class="logs" data-lat="-37.882833920280056" data-long="145.1416632143803">
                                        <td>
                                            <span class="badge badge-pill badge-danger">Alert log</span><br>
                                            <b>14:24:09 - 27/12/2019</b><br>
                                            Watch battery: 27%
                                        </td>
                                        <td class="td-actions text-right">
                                            <a target="_blank" href="https://www.google.com/maps/dir//-37.882833920280056,145.1416632143803"
                                               title="Get direction" class="btn btn-default btn-link btn-lg">
                                                <i class="material-icons">directions</i>
                                            </a>
                                            <button type="button" data-toggle="modal" data-target="#alertLogDetails" title="View details" class="btn btn-default btn-link btn-lg">
                                                <i class="material-icons">info</i>
                                            </button>
                                        </td>
                                    </tr>


                                    <tr class="logs" data-lat="-38.042411928573614" data-long="145.1096239604738">
                                        <td>
                                            <span class="badge badge-pill badge-info">Hourly log</span><br>
                                            <b>14:24:09 - 27/12/2019</b><br>
                                            Watch battery: 27%
                                        </td>
                                        <td class="td-actions text-right">
                                            <a target="_blank" href="https://www.google.com/maps/dir//-38.042411928573614,145.1096239604738" title="Get direction" class="btn btn-default btn-link btn-sm">
                                                <i class="material-icons">directions</i>
                                            </a>
                                            <button type="button" title="View details" data-toggle="modal" data-target="#hourlyLogDetails" class="btn btn-default btn-link btn-sm">
                                                <i class="material-icons">info</i>
                                            </button>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">

                <div class="copyright float-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script> Watch Over Me - User
                </div>
            </div>
        </footer>


        <div class="modal fade" id="logFilters" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Search Filters</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-horizontal">

                            <div class="row">
                                <label style="margin-top: 10px" class="col-md-3 col-form-label">
                                    Logs type:
                                </label>
                                <div class="col-md-9">
                                    <div class="form-group has-default">
                                        <select class="form-control" name="logsType">
                                            <option>All</option>
                                            <option>Alert logs</option>
                                            <option>Hourly logs</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-md-3 col-form-label">Date:</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control datepicker">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark btn-link">
                            <i class="fa fa-search"></i> &nbsp;
                            Search
                        </button>
                        <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="hourlyLogDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Houry Log Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th>
                                        Log ID:
                                    </th>
                                    <td>WOMP00000875</td>
                                </tr>
                                <tr>
                                    <th>
                                        Date/Time:
                                    </th>
                                    <td>21/05/2020 - 20:30</td>
                                </tr>
                                <tr>
                                    <th>
                                        Description:
                                    </th>
                                    <td>Log on hourly basis</td>
                                </tr>
                                <tr>
                                    <th>
                                        Type:
                                    </th>
                                    <td>Hourly log</td>
                                </tr>
                                <tr>
                                    <th>
                                        Device Battery level:
                                    </th>
                                    <td>35%</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="alertLogDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Alert Log Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>

                    <div class="modal-body">

                        <p><b id="aModalWearerName">Waqas Waheed</b> initiated help me request at <b id="aModalTime">14:24:09</b> on <b id="aModalDate">27/12/2019</b>.
                            <br>Device battery was <b id="aModalBattery">35%</b> at the time of request initiation</p>

                        <div style="background: #eeeeee" class="card card-timeline card-plain">
                            <div class="card-body">
                                <ul class="timeline timeline-inverted">
                                    <li class="timeline">
                                        <div class="timeline-badge danger">
                                            <i class="material-icons">card_travel</i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <span class="badge badge-pill badge-danger">Some Title</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Wifey made the best Father's Day meal ever. So thankful so happy so blessed. Thank you for making my family We just had fun with the “future” theme !!! It was a fun night all together ... The always rude Kanye Show at 2am Sold Out Famous viewing @ Figueroa and 12th in downtown.</p>
                                            </div>
                                            <h6>
                                                <i class="ti-time"></i>
                                                11 hours ago via Twitter
                                            </h6>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted">
                                        <div class="timeline-badge success">
                                            <i class="material-icons">card_travel</i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <span class="badge badge-pill badge-success">Another One</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Thank God for the support of my wife and real friends. I also wanted to point out that it’s the first album to go number 1 off of streaming!!! I love you Ellen and also my number one design rule of anything I do from shoes to music to homes is that Kim has to like it....</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted">
                                        <div class="timeline-badge info">
                                            <i class="material-icons">card_travel</i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <span class="badge badge-pill badge-info">Another Title</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Called I Miss the Old Kanye That’s all it was Kanye And I love you like Kanye loves Kanye Famous viewing @ Figueroa and 12th in downtown LA 11:10PM</p>
                                                <p>What if Kanye made a song about Kanye Royère doesn't make a Polar bear bed but the Polar bear couch is my favorite piece of furniture we own It wasn’t any Kanyes Set on his goals Kanye</p>
                                                <hr>
                                            </div>
                                            <div class="timeline-footer">
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-round btn-info dropdown-toggle" data-toggle="dropdown">
                                                        <i class="nc-icon nc-settings-gear-65"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')

    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="/userAssets/js/plugins/bootstrap-datetimepicker.min.js"></script>

    <script src="/userAssets/js/wearerServiceLogHistory.js"></script>

    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsaBSLRpDtQYzD5md-bnOYP61GBRN9oac&libraries=places&callback=initialMap"></script>

@endsection
