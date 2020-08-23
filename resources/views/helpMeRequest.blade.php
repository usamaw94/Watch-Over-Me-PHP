<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>
        Watch Over Me - Help me request
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/css/paper-dashboard.min.css" rel="stylesheet" />
    <link href="/assets/css/custom.css" rel="stylesheet">
</head>

<body class="lock-page">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container">
        <div class="navbar-wrapper">
            <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" href="javascript:;">Watch Over Me - Help me Request</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nc-icon nc-layout-11"></i>
                        Login to User Panel
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
<div class="wrapper wrapper-full-page ">
    <div class="full-page lock-page section-image" filter-color="black">
        <!--   you can change the color of the filter page using: data-color="blue | green | orange | red | purple" -->
        <div class="content" style="padding-top: 1vh">
            <div class="container">
                <div class="col-12">
                    <div class="card card-lock text-center">
                        <div class="card-header ">
                        </div>
                        <div class="card-body ">
                            @if($logDetails->response_status == 'No')
                                <h4 class="card-title" style="margin-top: 0px;margin-bottom: 20px"><b>{{ $serviceDetails->wearerFullName }}</b> needs your help !!</h4>
                            @else
                                <h4 class="card-title" style="margin-top: 0px;margin-bottom: 20px"><b>{{ $serviceDetails->wearerFullName }}</b> requested for help !!</h4>
                            @endif
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                    <th class="text-center">
                                        Service Id
                                    </th>
                                    <th>
                                        Wearer Phone Number
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Date - Time
                                    </th>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center">
                                            {{ $serviceDetails->service_id }}
                                        </td>
                                        <td>
                                            {{ $serviceDetails->wearerPhone }}
                                        </td>
                                        <td>
                                            {{ $serviceDetails->wearerEmail }}
                                        </td>
                                        <td>
                                            {{ $helpMeResponse->send_date }} - {{ $helpMeResponse->send_time }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="text-muted text-left card-category font-weight-normal">
                                        <i class="fa fa-map-marker"></i> &nbsp; Wearer initial location: <b>{{ $logDetails->locality }}</b>
                                    </h5>
                                </div>
                                <div class="col-md-4">
                                    <a href="https://www.google.com/maps/dir//{{ $logDetails->location_latitude }},{{ $logDetails->location_longitude }}"
                                        class="pull-right btn btn-default btn-sm">
                                        <i class="fa fa-location-arrow"></i> &nbsp; Get direction
                                    </a>
                                </div>
                            </div>
                            <input type="hidden" id="latitude" value="{{ $logDetails->location_latitude }}" readonly>
                            <input type="hidden" id="longitude" value="{{ $logDetails->location_longitude }}" readonly>
                            <div id="helpMeWearerLocation">
                            </div>
                            <hr>
                            <div class="row text-left">
                                <div class="col-md-6">
                                    <h5 class="text-info">
                                        @if($logDetails->response_status == 'No')
                                            <b>{{ $helpMeResponse->watcherFName }}, can you physically visit {{ $serviceDetails->wearerFullName }}?</b>
                                        @else
                                            <b>{{ $helpMeResponse->responded_by_name }}, accepted {{ $serviceDetails->wearerFullName }}'s request for help?</b>
                                        @endif
                                    </h5>
                                </div>
                                <div class="col-md-3 col-sm-7">
                                    <button data-user-id="{{ $helpMeResponse->watcherId }}" data-service-id="{{ $serviceDetails->service_id }}" data-log-id="{{ $logDetails->log_id }}" class="btn btn-block btn-success btn-lg btn-round">
                                        <i class="fa fa-check"></i> &nbsp; Yes
                                    </button>
                                </div>
                                <div class="col-md-3 col-sm-5">
                                    <button data-user-id="{{ $helpMeResponse->watcherId }}" data-service-id="{{ $serviceDetails->service_id }}" data-log-id="{{ $logDetails->log_id }}" class="btn btn-block btn-danger btn-lg btn-round">
                                        <i class="fa fa-times"></i> &nbsp; No
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-left text-muted">Help me request has already been sent to following watchers</h6>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="text-primary">
                                            <th class="text-center">
                                                Name
                                            </th>
                                            <th>
                                                Time Contacted
                                            </th>
                                            <th>
                                                Time Responded
                                            </th>
                                            <th>
                                                Response
                                            </th>
                                            </thead>
                                            <tbody>
                                            @foreach($helpMeResponseList as $hMRL)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $hMRL->watcherFullName }}
                                                </td>
                                                <td>
                                                    {{ $hMRL->send_date }} - {{ $hMRL->send_time }}
                                                </td>
                                                <td>
                                                    @if($hMRL->response_status == 'false')
                                                        --
                                                    @else
                                                        {{ $hMRL->reply_date }} - {{ $hMRL->reply_time }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($hMRL->response_status == 'false')
                                                        Not responded
                                                    @else
                                                        @if($hMRL->response_type == 'No')
                                                            Refused to help
                                                        @else
                                                            Accepted to help
                                                        @endif
                                                     @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer footer-black  footer-white ">
            <div class="container-fluid">
                <div class="row">
                    <div class="credits ml-auto">
              <span class="copyright">
                © <script>
                  document.write(new Date().getFullYear())
                </script>, Watch Over Me - Help Me Request
              </span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!--   Core JS Files   -->
<script src="/assets/js/core/jquery.min.js"></script>
<script src="/assets/js/core/popper.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<script src="/assets/js/plugins/moment.min.js"></script>
<!--  Plugin for the Bootstrap Table -->
<script src="/assets/js/plugins/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsaBSLRpDtQYzD5md-bnOYP61GBRN9oac&libraries=places&callback=initialMap"></script>
<!--  Notifications Plugin    -->
<script src="/assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/assets/js/paper-dashboard.min.js" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="/assets/js/helpMeRespond.js"></script>

</body>

</html>
