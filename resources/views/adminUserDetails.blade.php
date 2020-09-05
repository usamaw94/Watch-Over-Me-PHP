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
                <li>
                    <a href="/adminServices">
                        <i class="nc-icon nc-settings-gear-65"></i>
                        <p>Services</p>
                    </a>
                </li>
                <li class="active">
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
                    <a class="navbar-brand" href="/adminUserDetails?id={{ $userDetails->person_id }}">User Details</a>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="content">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="author">
                                <h5 class="title text-center text-primary">{{ $userDetails->full_name }}</h5>
                            </div>
                            <h5 class="text-muted">
                                ID: {{ $userDetails->person_id }}
                            </h5>

                            <h6 style="font-weight: normal">
                                <i class="fa fa-phone" aria-hidden="true"></i> &nbsp; {{ $userDetails->phone }}
                            </h6>
                            <h6 class="text-lowercase text-muted">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i> &nbsp; {{ $userDetails->email }}
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="button-container">
                                <div class="row">
                                    <div class="col-12">
                                        <h6>User registered in services</h6>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-6 ml-auto">
                                        <h5><b>{{ $countServiceAsWearer }}</b>&nbsp; service<br><small>As wearer</small></h5>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-6 ml-auto mr-auto">
                                        <h5><b>{{ $countServiceAsWatcher }}</b>&nbsp; service(s)<br><small>As watcher</small></h5>
                                    </div>
                                    <div class="col-lg-3 mr-auto">
                                        <h5><b>{{ $countServiceAsCustomer }}</b>&nbsp; service(s)<br><small>As customer</small></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul id="tabs" class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#wearerService" role="tab" aria-expanded="true">As Wearer</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#watcherServices" role="tab" aria-expanded="false">As Watcher</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#customerServices" role="tab" aria-expanded="false">As Customer</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="my-tab-content" class="tab-content text-center">

                                <div class="tab-pane active" id="wearerService" role="tabpanel" aria-expanded="true">

                                    @if($countServiceAsWearer == 0)

                                        <div>
                                            <h6 class="text-danger">
                                                User is not registered as a wearer in any service
                                            </h6>
                                        </div>

                                    @else

                                        <div class="table-responsive">
                                            <table class="table no-border">
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Service ID:
                                                    </th>
                                                    <td>
                                                        {{ $serviceAsWearer->service_id }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Created On:
                                                    </th>
                                                    <td>
                                                        {{ $serviceAsWearer->created_at }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Status:
                                                    </th>
                                                    <td>
                                                        {{ $serviceAsWearer->service_status }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Customer:
                                                    </th>
                                                    <td>
                                                        <span data-id="{{ $serviceAsWearer->customerId }}">{{ $serviceAsWearer->customerFullName }} </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;No. of Watchers:
                                                    </th>
                                                    <td>
                                                        {{ $serviceAsWearer->no_of_watchers }}
                                                    </td>
                                                </tr>
                                            </table>
                                            <a href="/adminServiceDetails/?id={{ $serviceAsWearer->service_id }}" class="btn btn-default">View more details</a>
                                        </div>

                                    @endif
                                </div>

                                <div class="tab-pane" id="watcherServices" role="tabpanel" aria-expanded="false">

                                    @if($countServiceAsWatcher == 0)

                                        <div>
                                            <h6 class="text-danger">
                                                User is not registered as a watcher in any service
                                            </h6>
                                        </div>

                                    @else

                                        <div class="table-responsive">
                                        <table class="table">
                                            <thead class="text-primary">
                                            <th class="text-center">
                                                Service Id
                                            </th>
                                            <th>
                                                Created on
                                            </th>
                                            <th>
                                                Wearer Name
                                            </th>
                                            <th>
                                                Customer Name
                                            </th>
                                            <th class="text-center">
                                                No. of watchers
                                            </th>
                                            <th class="text-center">
                                                Status
                                            </th>
                                            <th class="text-right">
                                                Actions
                                            </th>
                                            </thead>
                                            <tbody>
                                            @foreach($serviceAsWatcher as $sawt)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $sawt->service_id }}
                                                </td>
                                                <td>
                                                    {{ $sawt->created_at }}
                                                </td>
                                                <td class="link-text customer-name" data-toggle="modal" data-target="#wearerDetails">
                                                    {{ $sawt->wearerFullName }}
                                                </td>
                                                <td class="link-text customer-name" data-toggle="modal" data-target="#customerDetails">
                                                    {{ $sawt->customerFullName }}
                                                </td>
                                                <td class="link-text customer-name text-center" data-toggle="modal" data-target="#watcherDetails">
                                                    <b class="link-text watcher-num">{{ $sawt->no_of_watchers }}</b>
                                                </td>
                                                <td class="text-center">
                                                    {{ $sawt->service_status }}
                                                </td>
                                                <td class="text-right">
                                                    <a href="/adminServiceDetails/?id={{ $sawt->service_id }}" type="button" rel="tooltip" class="btn btn-outline-default btn-round btn-sm">
                                                        Details
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @endif

                                </div>

                                <div class="tab-pane" id="customerServices" role="tabpanel" aria-expanded="false">

                                    @if($countServiceAsCustomer == 0)

                                        <div>
                                            <h6 class="text-danger">
                                                User is not registered as a customer in any service
                                            </h6>
                                        </div>

                                    @else

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="text-primary">
                                                <th class="text-center">
                                                    Service Id
                                                </th>
                                                <th>
                                                    Created on
                                                </th>
                                                <th>
                                                    Wearer Name
                                                </th>
                                                <th class="text-center">
                                                    No. of watchers
                                                </th>
                                                <th class="text-center">
                                                    Status
                                                </th>
                                                <th class="text-right">
                                                    Actions
                                                </th>
                                                </thead>
                                                <tbody>
                                                @foreach($serviceAsCustomer as $sac)
                                                    <tr>
                                                        <td class="text-center">
                                                            {{ $sac->service_id }}
                                                        </td>
                                                        <td>
                                                            {{ $sac->created_at }}
                                                        </td>
                                                        <td class="link-text customer-name" data-toggle="modal" data-target="#wearerDetails">
                                                            {{ $sac->wearerFullName }}
                                                        </td>
                                                        <td class="link-text customer-name text-center" data-toggle="modal" data-target="#watcherDetails">
                                                            <b class="link-text watcher-num">{{ $sac->no_of_watchers }}</b>
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $sac->service_status }}
                                                        </td>
                                                        <td class="text-right">
                                                            <a href="/adminServiceDetails/?id={{ $sac->service_id }}" type="button" rel="tooltip" class="btn btn-outline-default btn-round btn-sm">
                                                                Details
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    @endif

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
