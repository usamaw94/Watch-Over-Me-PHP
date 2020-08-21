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
            <div class="user">
                <div class="photo">
                    <img src="/assets/img/faces/wom-admin.png" />
                </div>
                <div class="info">
                    <a data-id="{{ Auth::user()->id }}" data-toggle="collapse" href="#collapseExample" class="collapsed">
              <span>
                {{ Auth::user()->name }}
                <b class="caret"></b>
              </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="#">
                                    <span class="sidebar-mini-icon">EP</span>
                                    <span class="sidebar-normal">Edit Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="/adminLogout">
                                    <i class="nc-icon nc-button-power"></i>
                                    <span class="sidebar-normal">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li>
                    <a href="/admin">
                        <i class="nc-icon nc-bank"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="active ">
                    <a href="/adminServices">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>Services</p>
                    </a>
                </li>
                <li>
                    <a href="/adminUsers">
                        <i class="nc-icon nc-single-02"></i>
                        <p>Users</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">

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
                    <a class="navbar-brand" href="javascript:;">Service Logs</a>
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

                <div class="col-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title">Service ID: <span id="serviceId">{{ $serviceDetails->service_id }}</span></h4>
                            <button id="showWearerLocation" data-toggle="modal" data-target="#trackWearer" class="btn btn-outline-primary btn-round btn-sm">Track Wearer</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-sm-6">
                    <div class="card maps-container">
                        <div class="card-header ">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class='card-title'>Wearer location</h4>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-right card-category">
                                        <i class="fa fa-map-marker"></i> &nbsp;
                                        <span>Greenvale, Victoria, Australia</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div id="googleMap"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="card">
                        <div class="card-header ">
                            <button class="pull-right btn btn-default btn-sm">Logs History</button>
{{--                            <button data-toggle="modal" data-target="#logFilters" style="float: right" class="btn btn-outline-light btn-icon btn-sm btn-round" title="Apply filters"><i class="fa fa-filter"></i></button>--}}
                            <h4 class='card-title'>Log list</h4>
                            <hr class="no-space">
                        </div>
                        <div id="logsContainer" class="card-body logs-container">

                            <div id="logsContent">

                                @foreach($logs as $lg)

                                    @if ($lg->log_type == 'Hourly Log')

                                        <div id="logID{{ $lg->id }}"
                                             data-lat="{{ $lg->location_latitude }}"
                                             data-long="{{ $lg->location_longitude }}"
                                             class="timeline-panel logs">
                                            <div class="timeline-body">
                                                <div class="logs-action">
                                                    <a target="_blank" href="https://www.google.com/maps/dir//-37.{{ $lg->location_latitude }},{{ $lg->location_longitude }}"
                                                       title="Get directions"
                                                       class="btn btn-outline-info btn-icon btn-round">
                                                        <i class="fa fa-location-arrow"></i>
                                                    </a>
                                                    <button title="View log details" type="button" class="btn btn-outline-info btn-icon btn-round show-hourly-log-details"
                                                    data-id="{{ $lg->id }}"
                                                    data-date="{{ $lg->log_date }}"
                                                    data-time="{{ $lg->log_time }}"
                                                    data-description="{{ $lg->log_text }}"
                                                    data-type="{{ $lg->log_type }}"
                                                    data-battery="{{ $lg->battery_percentage }}">
                                                        <i class="fa fa-info-circle"></i>
                                                    </button>
                                                </div>
                                                <span class="badge badge-pill badge-info">{{ $lg->log_type }}</span><br>
                                                <b>{{ $lg->log_time }} - {{ $lg->log_date }}</b>
                                                <p>Watch battery: {{ $lg->battery_percentage }}%</p>
                                            </div>
                                        </div>
                                        <hr class="no-space">

                                    @elseif($lg->log_type == 'Alert Log')

                                        <div id="logID{{ $lg->id }}"
                                             data-lat="{{ $lg->location_latitude }}"
                                             data-long="{{ $lg->location_longitude }}"
                                             class="timeline-panel logs">
                                            <div class="timeline-body">
                                                <div class="logs-action">
                                                    <a target="_blank" href="https://www.google.com/maps/dir//{{ $lg->location_latitude }},{{ $lg->location_longitude }}"
                                                       title="Get directions"
                                                       class="btn btn-outline-danger btn-icon btn-round">
                                                        <i class="fa fa-location-arrow"></i>
                                                    </a>
                                                    <button title="View log details" type="button" class="btn btn-outline-danger btn-icon btn-round show-alert-log-details"
                                                            data-id="{{ $lg->id }}"
                                                            data-date="{{ $lg->log_date }}"
                                                            data-time="{{ $lg->log_time }}"
                                                            data-description="{{ $lg->log_text }}"
                                                            data-type="{{ $lg->log_type }}"
                                                            data-battery="{{ $lg->battery_percentage }}">
                                                        <i style="margin-left: -12px;margin-top: -12px" class="fa fa-spinner fa-spin sr-only"></i>
                                                        <i class="fa fa-info-circle"></i>
                                                    </button>
                                                </div>
                                                <span class="badge badge-pill badge-danger">{{ $lg->log_type }}</span><br>
                                                <b>{{ $lg->log_time }} - {{ $lg->log_date }}</b>
                                                <p>Watch battery: {{ $lg->battery_percentage }}%</p>
                                            </div>
                                        </div>
                                        <hr class="no-space">

                                    @endif
                                @endforeach

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>



        <footer class="footer footer-black  footer-white ">
            <div class="container-fluid">
                <div class="row">
                    <nav class="footer-nav">
                    </nav>
                    <div class="credits ml-auto">
              <span class="copyright">
                Watch Over Me
              </span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div class="modal fade" id="logFilters" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Search filters</h4>
                </div>

                <form id="logFiltersForm">

                    <div class="modal-body">
                        <input type="text" value="{{ $serviceDetails->service_id }}" name="serviceId" readonly>
                        <div class="card card-plain">
                            <label>Logs type</label>
                            <div class="form-group">
                                <select class="form-control" name="logsType">
                                    <option>All</option>
                                    <option>Alert log</option>
                                    <option>Hourly log</option>
                                </select>
                            </div>
                            <label>Date</label>
                            <div class="form-group">
                                <input type="text" name="logsDate" class="form-control logs-date-picker">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="left-side">
                            <button type="submit" class="btn btn-link">
                                Apply filters
                                 &nbsp; <span><i id="apllyLogFilterLoad" class="fa fa-spinner fa-spin sr-only"></i></span>
                            </button>
                        </div>
                        <div class="divider"></div>
                        <div class="right-side">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-link">Close</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="hourlyLogDetails" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Hourly Log Details</h4>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table no-border">
                            <tr>
                                <th>
                                    Log ID:
                                </th>
                                <td id="hModalId">
                                    WOMP00000875
                                </td>
                            </tr>
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
                                    Device Battery level
                                </th>
                                <td id="hModalBattery">
                                    35%
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-link">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="alertLogDetails" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Alert Log Details</h4>
                </div>

                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table no-border">
                            <thead class="">
                            <th>
                                Log ID
                            </th>
                            <th>
                                Date - Time
                            </th>
                            <th>
                                Description
                            </th>
                            <th>
                                Type
                            </th>
                            <th>
                                Watch Battey(%)
                            </th>
                            </thead>
                            <tbody>
                            <tr>
                                <td id="aModalId">
                                    1
                                </td>
                                <td id="aModalDateTime">
                                    13:00 - 01/06/2017
                                </td>
                                <td id="aModalDescription">
                                    I need help
                                </td>
                                <td id="aModalType">
                                    Alert Log
                                </td>
                                <td id="aModalBattery">
                                    50%
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="background: #f4f3ed" class="card card-timeline card-plain">
                        <div class="card-body">
                            <ul class="timeline timeline-inverted">
                                <li class="timeline">
                                    <div class="timeline-badge danger">
                                        <i class="nc-icon nc-single-copy-04"></i>
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
                                        <i class="nc-icon nc-sun-fog-29"></i>
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
                                        <i class="nc-icon nc-world-2"></i>
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
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-link">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="trackWearer" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Track Wearer</h4>
                </div>
                <div class="modal-body">
                    <div id="wearerLocationMap"></div>
                </div>
                <div class="modal-footer">
                    <div class="left-side">
                        <a target="_blank" href="https://www.google.com/maps/dir//-38.042411928573614,145.1096239604738" class="btn btn-link">
                            <i class="fa fa-location-arrow"></i> &nbsp;
                            Get directions
                        </a>
                    </div>
                    <div class="divider"></div>
                    <div class="right-side">
                        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger btn-link">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

{{--    <script>--}}

{{--        var serviceId = $('#serviceId').text();--}}

{{--        window.Echo.channel('showlogs.'+serviceId)--}}
{{--            .listen('HourlyLogCreated', (e) => {--}}
{{--                alert("data");--}}
{{--            });--}}

{{--    </script>--}}

    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsaBSLRpDtQYzD5md-bnOYP61GBRN9oac&libraries=places&callback=initialMap"></script>

    <script src="/assets/js/serviceLogs.js" type="text/javascript"></script>
@endsection
