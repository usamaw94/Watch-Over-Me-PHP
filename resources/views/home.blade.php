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
                                <a class="nav-link" href="/userLogout"
{{--                                   onclick="event.preventDefault();--}}
{{--                                    document.getElementById('logout-form').submit();"--}}
                                >
                                    <span class="sidebar-mini"> LG </span>
                                    <span class="sidebar-normal"> Logout </span>
                                </a>
{{--                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                                    @csrf--}}
{{--                                </form>--}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/home">
                        <i class="material-icons">dashboard</i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="/userAsWearer">
                        <i class="material-icons">settings</i>
                        <p> As wearer </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="/userAsWatcher">
                        <i class="material-icons">settings</i>
                        <p> As watcher </p>
                    </a>
                </li>
                <li class="nav-item ">
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
                    <a class="navbar-brand" href="javascript:;">Dashboard</a>
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
            <div class="content">
                <div class="container-fluid">

                    <div class="row">

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-rose card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">settings</i>
                                    </div>
                                    <p class="card-category">User As</p>
                                    <h3 class="card-title">Wearer</h3>
                                </div>
                                <div class="card-footer">
                                    <a href="/userAsWearer" class="stats">
                                        <i class="material-icons">remove_red_eye</i> &nbsp; View
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-success card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">settings</i>
                                    </div>
                                    <p class="card-category">User As</p>
                                    <h3 class="card-title">Watcher</h3>
                                </div>
                                <div class="card-footer">
                                    <a href="/userAsWatcher" class="stats">
                                        <i class="material-icons">remove_red_eye</i> &nbsp; View
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-info card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">settings</i>
                                    </div>
                                    <p class="card-category">User As</p>
                                    <h3 class="card-title">Customer</h3>
                                </div>
                                <div class="card-footer">
                                    <a href="/userAsCustomer" class="stats">
                                        <i class="material-icons">remove_red_eye</i> &nbsp; View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4 class="card-title">User Registered Services
                                        <!--                      <small class="description">Horizontal Tabs</small>-->
                                    </h4>
                                </div>
                                <div class="card-body ">
                                    <ul class="nav nav-pills nav-pills-warning" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#wearerTab" role="tablist">
                                                Wearer
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#watcherTab" role="tablist">
                                                Watcher
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#customerTab" role="tablist">
                                                Customer
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content tab-space">

                                        <div class="tab-pane active" id="wearerTab">

                                            @if($countServiceAsWearer == 0)

                                                <div>
                                                    <h6 class="text-danger">
                                                        User is not registered as a wearer in any service
                                                    </h6>
                                                </div>

                                            @else

                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <b>Service ID:</b>
                                                        </td>
                                                        <td>{{ $serviceAsWearer->service_id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Created On:</b>
                                                        </td>
                                                        <td>{{ $serviceAsWearer->created_at }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Status:</b>
                                                        </td>
                                                        <td>{{ $serviceAsWearer->service_status }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>Customer:</b>
                                                        </td>
                                                        <td>
                                                            <span data-id="{{ $serviceAsWearer->customerId }}">{{ $serviceAsWearer->customerFullName }} </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <b>No. of Watchers:</b>
                                                        </td>
                                                        <td>{{ $serviceAsWearer->no_of_watchers }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <a href="/userAsWearer" class="btn btn-info">
                                                <span class="btn-label">
                                                    <i class="material-icons">info</i>
                                                </span>
                                                 &nbsp; View Full Details
                                            </a>

                                            @endif
                                        </div>

                                        <div class="tab-pane" id="watcherTab">

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
                                                                <td data-id="{{ $sawt->wearer_id }}" data-type="wearer" class="person-details-link person-details-modal">
                                                                    {{ $sawt->wearerFullName }} &nbsp; <i class="fa fa-spinner fa-spin sr-only"></i>
                                                                </td>
                                                                <td data-id="{{ $sawt->customer_id }}" data-type="customer" class="person-details-link person-details-modal">
                                                                    {{ $sawt->customerFullName }} &nbsp; <i class="fa fa-spinner fa-spin sr-only"></i>
                                                                </td>
                                                                <td data-id="{{ $sawt->service_id }}" class="text-center person-details-link watcher-details-modal">
                                                                    {{ $sawt->no_of_watchers }} &nbsp; <i class="fa fa-spinner fa-spin sr-only"></i>
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $sawt->service_status }}
                                                                </td>
                                                                <td class="text-right">
                                                                    <a href="/userAsWatcherService/?id={{ $sawt->service_id }}" rel="tooltip" class="btn btn-info btn-sm">
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

                                        <div class="tab-pane" id="customerTab">

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
                                                                <td data-id="{{ $sac->wearer_id }}" data-type="wearer" class="person-details-link person-details-modal">
                                                                    {{ $sac->wearerFullName }} &nbsp; <i class="fa fa-spinner fa-spin sr-only"></i>
                                                                </td>
                                                                <td data-id="{{ $sac->service_id }}" class="text-center person-details-link watcher-details-modal">
                                                                    {{ $sac->no_of_watchers }} &nbsp; <i class="fa fa-spinner fa-spin sr-only"></i>
                                                                </td>
                                                                <td class="text-center">
                                                                    {{ $sac->service_status }}
                                                                </td>
                                                                <td class="text-right">
                                                                    <a href="/userAsCustomerService/?id={{ $sac->service_id }}" type="button" rel="tooltip" class="btn btn-info btn-sm">
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


        <div class="modal fade" id="personDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="personModalTitle" class="modal-title"></h4>
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
                                        ID:
                                    </th>
                                    <td id="modalUserId"></td>
                                </tr>
                                <tr>
                                    <th>
                                        Name:
                                    </th>
                                    <td id="modalUserName"></td>
                                </tr>
                                <tr>
                                    <th>
                                        Phone:
                                    </th>
                                    <td id="modalUserPhone"></td>
                                </tr>
                                <tr>
                                    <th>
                                        Email:
                                    </th>
                                    <td id="modalUserEmail"></td>
                                </tr>
                                <tr>
                                    <th>Verification Status</th>
                                    <td id="modalUserVerification"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
{{--                        <button type="button" class="btn btn-link">Full details</button>--}}
                        <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="watchersDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="personModalTitle" class="modal-title">Watcher Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-gray">
                                <tr>
                                    <th>Priority Order</th>
                                    <th>ID:</th>
                                    <th>Name:</th>
                                    <th>Phone:</th>
                                    <th>Email:</th>
                                    <th>Verification Status</th>
                                </tr>
                                </thead>
                                <tbody id="watchersList">
                                </tbody>
                            </table>
                        </div>

                        <p class="text-muted">Total Watchers: <b id="totalWatchersNum"></b></p>

                    </div>
                    <div class="modal-footer">
                        {{--                        <button type="button" class="btn btn-link">Full details</button>--}}
                        <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')

    <script src="/userAssets/js/dashboard.js"></script>

@endsection
