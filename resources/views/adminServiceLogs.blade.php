@extends('layouts.adminApp')

@section('styling')

@endsection

@section('content')

    <div class="sidebar" data-color="default" data-active-color="danger">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color=" default | primary | info | success | warning | danger |"
      -->
        <div class="logo">
            <a href="https://www.creative-tim.com/" class="simple-text logo-mini">
                <div class="logo-image-small">
                    <img src="../../assets/img/logo-small.png">
                </div>
                <!-- <p>CT</p> -->
            </a>
            <a href="https://www.creative-tim.com/" class="simple-text logo-normal">
                Watch Over Me
                <!-- <div class="logo-image-big">
                  <img src="../../assets/img/logo-big.png">
                </div> -->
            </a>
        </div>
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="logo">
                <a href="https://www.creative-tim.com" class="simple-text logo-mini">
                    <!-- <div class="logo-image-small">
                      <img src="./assets/img/logo-small.png">
                    </div> -->
                    <!-- <p>CT</p> -->
                </a>
                <a href="https://www.creative-tim.com" class="simple-text logo-normal">
                    Watch Over Me
                    <!-- <div class="logo-image-big">
                      <img src="../assets/img/logo-big.png">
                    </div> -->
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li>
                        <a href="dashboard.html">
                            <i class="nc-icon nc-bank"></i>
                            <p>Home</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="services.html">
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
                        <a href="javascript:;">
                            <i class="nc-icon nc-button-power"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </div>
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
                    <form>
                        <div class="input-group no-border">
                            <input type="text" value="" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="nc-icon nc-zoom-split"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link btn-magnify" href="javascript:;">
                                <i class="nc-icon nc-layout-11"></i>
                                <p>
                                    <span class="d-lg-none d-md-block">Stats</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item btn-rotate dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="nc-icon nc-bell-55"></i>
                                <p>
                                    <span class="d-lg-none d-md-block">Some Actions</span>
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-rotate" href="javascript:;">
                                <i class="nc-icon nc-settings-gear-65"></i>
                                <p>
                                    <span class="d-lg-none d-md-block">Account</span>
                                </p>
                            </a>
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
                            <h4 class='card-title'>Wearer location</h4>
                        </div>
                        <div class="card-body ">
                            <div id="googleMap"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="card">
                        <div class="card-header ">
                            <button data-toggle="modal" data-target="#logFilters" style="float: right" class="btn btn-outline-light btn-icon btn-sm btn-round" title="Apply filters"><i class="fa fa-filter"></i></button>
                            <h4 class='card-title'>Log list</h4>
                            <hr class="no-space">
                        </div>
                        <div id="logsContainer" class="card-body logs-container">

                            <div id="logsContent">

                                @foreach($logs as $lg)

                                    @if ($lg->log_type == 'Hourly Log')

                                        <div data-lat="{{ $lg->location_latitude }}" data-long="{{ $lg->location_longitude }}" class="timeline-panel logs">
                                            <div class="timeline-body">
                                                <div class="logs-action">
                                                    <a target="_blank" href="https://www.google.com/maps/dir//-37.{{ $lg->location_latitude }},{{ $lg->location_longitude }}"
                                                       title="Get directions"
                                                       class="btn btn-outline-info btn-icon btn-round">
                                                        <i class="fa fa-location-arrow"></i>
                                                    </a>
                                                    <button title="View log details" type="button" data-toggle="modal" data-target="#hourlyLogDetails" class="btn btn-outline-info btn-icon btn-round">
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

                                        <div data-lat="{{ $lg->location_latitude }}" data-long="{{ $lg->location_longitude }}" class="timeline-panel logs">
                                            <div class="timeline-body">
                                                <div class="logs-action">
                                                    <a target="_blank" href="https://www.google.com/maps/dir//{{ $lg->location_latitude }},{{ $lg->location_longitude }}"
                                                       title="Get directions"
                                                       class="btn btn-outline-danger btn-icon btn-round">
                                                        <i class="fa fa-location-arrow"></i>
                                                    </a>
                                                    <button title="View log details" type="button" data-toggle="modal" data-target="#alertLogDetails" class="btn btn-outline-danger btn-icon btn-round">
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

                <form method="#" action="#">

                    <div class="modal-body">
                        <div class="card card-plain">
                            <label>Logs type</label>
                            <div class="form-group">
                                <select class="form-control" name="logsType">
                                    <option>Alert log</option>
                                    <option>Hourly log</option>
                                </select>
                            </div>
                            <label>Date</label>
                            <div class="form-group">
                                <input type="text" class="form-control logs-date-picker">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="left-side">
                            <button type="button" class="btn btn-link">Apply filters</button>
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
                                <td>
                                    WOMP00000875
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Date/Time:
                                </th>
                                <td>
                                    21/05/2020 - 20:30
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Description:
                                </th>
                                <td>
                                    Log on hourly basis
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Type:
                                </th>
                                <td>
                                    Hourly log
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Device Battery level
                                </th>
                                <td>
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
                                <td>
                                    1
                                </td>
                                <td>
                                    13:00 - 01/06/2017
                                </td>
                                <td>
                                    I need help
                                </td>
                                <td>
                                    Alert Log
                                </td>
                                <td>
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
