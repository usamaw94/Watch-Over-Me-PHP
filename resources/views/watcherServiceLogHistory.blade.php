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
                    <a class="nav-link" href="/userAsWearer">
                        <i class="material-icons">settings</i>
                        <p> As wearer </p>
                    </a>
                </li>
                <li class="nav-item active">
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

        <div id="reloadPage" class="content">
            <div id="pageContent" class="container-fluid">

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
                                                <a href="{{ $logs->previousPageUrl() }}" rel="tooltip" title="Previous" class="btn btn-white btn-link btn-sm">
                                                    <i class="fa fa-angle-left"></i>
                                                </a>
                                                <a href="{{ $logs->nextPageUrl() }}" type="button" rel="tooltip" title="Next" class="btn btn-white btn-link btn-sm">
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body logs-container">
                                <table class="table table-hover">
                                    <tbody>

                                    @foreach($logs as $lg)

                                        @if ($lg->log_type == 'Hourly Log')

                                            <tr id="{{ $lg->log_id }}"
                                                data-lat="{{ $lg->location_latitude }}"
                                                data-long="{{ $lg->location_longitude }}"
                                                data-locality="{{ $lg->locality }}"
                                                class="logs">
                                                <td>
                                                    <span class="badge badge-pill badge-info">{{ $lg->log_type }}</span><br>
                                                    <b>{{ $lg->log_time }} - {{ $lg->log_date }}</b><br>
                                                    Watch battery: {{ $lg->battery_percentage }}%
                                                </td>
                                                <td class="td-actions text-right">
                                                    <a target="_blank" href="https://www.google.com/maps/dir//{{ $lg->location_latitude }},{{ $lg->location_longitude }}" title="Get direction" class="btn btn-default btn-link btn-sm">
                                                        <i class="material-icons">directions</i>
                                                    </a>
                                                    <button type="button" title="View details" class="btn btn-default btn-link btn-sm show-hourly-log-details"
                                                            data-id="{{ $lg->id }}"
                                                            data-date="{{ $lg->log_date }}"
                                                            data-time="{{ $lg->log_time }}"
                                                            data-description="{{ $lg->log_text }}"
                                                            data-type="{{ $lg->log_type }}"
                                                            data-battery="{{ $lg->battery_percentage }}">
                                                        <i class="material-icons">info</i>
                                                    </button>
                                                </td>
                                            </tr>

                                        @elseif($lg->log_type == 'Alert Log')

                                            <tr id="{{ $lg->log_id }}"
                                                data-lat="{{ $lg->location_latitude }}"
                                                data-long="{{ $lg->location_longitude }}"
                                                data-locality="{{ $lg->locality }}"
                                                class="logs">
                                                <td>
                                                    <span class="badge badge-pill badge-danger">{{ $lg->log_type }}</span><br>
                                                    <b>{{ $lg->log_time }} - {{ $lg->log_date }}</b><br>
                                                    Watch battery: {{ $lg->battery_percentage }}%
                                                </td>
                                                <td class="td-actions text-right">
                                                    <a target="_blank" href="https://www.google.com/maps/dir//{{ $lg->location_latitude }},{{ $lg->location_longitude }}"
                                                       title="Get direction" class="btn btn-default btn-link btn-sm">
                                                        <i class="material-icons">directions</i>
                                                    </a>
                                                    <button type="button" title="View details" class="btn btn-default btn-link btn-sm show-alert-log-details"
                                                            data-id="{{ $lg->log_id }}"
                                                            data-wearer-name="{{ $wearerDetails->full_name }}">
                                                        <i class="fa fa-spinner fa-spin alert-log-spinner sr-only"></i>
                                                        <i class="alert-log-Info-Icon material-icons">info</i>
                                                    </button>
                                                </td>
                                            </tr>

                                        @endif

                                    @endforeach

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

                    <form id="logFiltersForm">

                        <div class="modal-body">
                            <div class="form-horizontal">

                                <input type="hidden" value="{{ $serviceDetails->service_id }}" name="serviceId" readonly>

                                <div class="row">
                                    <label style="margin-top: 10px" class="col-md-3 col-form-label">
                                        Logs type:
                                    </label>
                                    <div class="col-md-9">
                                        <div class="form-group has-default">
                                            <select class="form-control" name="logsType">
                                                <option value="all">All</option>
                                                <option value="alert">Alert logs</option>
                                                <option value="hourly">Hourly logs</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <label style="margin-top: 10px" class="col-md-3 col-form-label">Date:</label>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="text" name="logsDate" class="form-control datepicker">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-dark btn-link">
                                <i class="fa fa-search"></i> &nbsp;
                                Search &nbsp;
                                <span><i id="apllyLogFilterLoad" class="fa fa-spinner fa-spin sr-only"></i></span>
                            </button>
                            <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close</button>
                        </div>

                    </form>

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
                                        Date/Time:
                                    </th>
                                    <td id="hModalDateTime">
                                        21/05/2020 - 20:30
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Description:
                                    </th>
                                    <td id="hModalDescription">
                                        Log on hourly basis
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Type:
                                    </th>
                                    <td id="hModalType">
                                        Hourly log
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Device Battery level:
                                    </th>
                                    <td id="hModalBattery">
                                        35%
                                    </td>
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

                        <p><b id="aModalWearerName"></b> initiated help me request at <b id="aModalTime"></b> on <b id="aModalDate"></b>.
                            <br>Device battery was <b id="aModalBattery"></b> at the time of request initiation</p>

                        <span id="helpMeResponse"></span>
                        <div style="background: #eeeeee" class="card card-timeline card-plain">
                            <div class="card-body">
                                <h5 class="text-center text-muted">Help Me Request Flow</h5>
                                <ul id="alertLogTimeline" class="timeline timeline-inverted">
                                    <li class="timeline">
                                        <div class="timeline-badge info">
                                            <i class="material-icons">account_circle</i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <span class="badge badge-pill badge-info">Help Me Request</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p>Request was sent to <b>Usama Waheed</b></p>
                                            </div>
                                            <h6>
                                                <i class="ti-time"></i>
                                                02:18:43 pm - 25 August 2020
                                            </h6>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted">
                                        <div class="timeline-badge success">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <span class="badge badge-pill badge-success">Response</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p><b>Usama Waheed</b> accepted the help request</p>
                                            </div>
                                            <h6>
                                                <i class="ti-time"></i>
                                                02:18:43 pm - 25 August 2020
                                            </h6>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted">
                                        <div class="timeline-badge danger">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <span class="badge badge-pill badge-danger">Response</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p><b>Usama Waheed</b> declined the help request</p>
                                            </div>
                                            <h6>
                                                <i class="ti-time"></i>
                                                02:18:43 pm - 25 August 2020
                                            </h6>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted">
                                        <div class="timeline-badge warning">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <span class="badge badge-pill badge-warning">Response</span>
                                            </div>
                                            <div class="timeline-body">
                                                <p><b>Usama Waheed</b> didn't respond</p>
                                            </div>
                                            <h6>
                                                <i class="ti-time"></i>
                                                02:18:43 pm - 25 August 2020
                                            </h6>
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

    <script src="/userAssets/js/watcherServiceLogHistory.js"></script>

    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsaBSLRpDtQYzD5md-bnOYP61GBRN9oac&libraries=places&callback=initialMap"></script>

@endsection
