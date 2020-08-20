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
                    <a href="/admin">
                        <i class="nc-icon nc-bank"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="active">
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
                    <a class="navbar-brand" href="/adminServices">Services</a>
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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div style="margin-top: 10px">
                                        <div class="input-group no-border">
                                            <input type="text" id="servicesSearchText" class="form-control" placeholder="Search user">
                                            <div id="searchServices" class="input-group-append btn btn-default">
                                                <i style="font-size: 16px" class="nc-icon nc-zoom-split"></i>
                                                &nbsp;&nbsp;
                                                <span id="servicesSearchLoad" class="sr-only"><i class="fa fa-refresh fa-spin"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <a href="/adminCreateService" class="btn btn-outline-primary btn-block btn-round"><i class="fa fa-plus"></i> &nbsp; Create new service</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="pull-right">
                                <div id="paginationContainer">
                                    Showing {{($services->currentPage()-1)* $services->perPage() + 1}} to
                                    {{ ($services->currentPage()-1)* $services->perPage() + $services->perPage() }} of
                                    {{ $services->total() }} services &nbsp;
                                    <a href="{{ $services->previousPageUrl() }}" class="btn btn-outline-default btn-sm btn-icon btn-round">
                                        <i class="fa fa-angle-left" style="font-size: 25px" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ $services->nextPageUrl() }}" class="btn btn-outline-default btn-sm btn-icon btn-round">
                                        <i class="fa fa-angle-right" style="font-size: 25px" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <h4 class="card-title"> Services List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                    <th class="text-center">
                                        Service Id
                                    </th>
                                    <th>
                                        WOM number
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
                                    <tbody id="showServiceList">
                                    @foreach($services as $svc)
                                    <tr>
                                        <td class="text-center">
                                            {{ $svc->service_id }}
                                        </td>
                                        <td>
                                            {{ $svc->wom_num }}
                                        </td>
                                        <td class="link-text wearer-name" data-id="{{ $svc->wearer_id }}">
                                            {{ $svc->wearerFName }} {{ $svc->wearerLName }} &nbsp; <i class="fa fa-refresh fa-spin wearer-details-load sr-only"></i>
                                        </td>
                                        <td class="link-text customer-name" data-id="{{ $svc->customer_id }}">
                                            {{ $svc->customerFName }} {{ $svc->customerLName }} &nbsp; <i class="fa fa-refresh fa-spin customer-details-load sr-only"></i>
                                        </td>
                                        <td class="link-text watcher-name text-center" data-id="{{ $svc->service_id }}">
                                            <b class="link-text watcher-num">{{ $svc->no_of_watchers }}</b> &nbsp; <i class="fa fa-refresh fa-spin watchers-details-load sr-only"></i>
                                        </td>
                                        <td class="text-center">
                                            {{ $svc->service_status }}
                                        </td>
                                        <td class="text-right">
                                            <a target="_blank" href="/adminServiceDetails/?id={{$svc->service_id}}" rel="tooltip" class="btn btn-outline-default btn-round btn-sm">
                                                Details
                                            </a>
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

    <div class="modal fade" id="wearerDetails" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Wearer Details</h4>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table no-border">
                            <tr>
                                <th>
                                    Wearer ID:
                                </th>
                                <td id="modalWearerId">

                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Name:
                                </th>
                                <td id="modalWearerName">

                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Phone Number:
                                </th>
                                <td id="modalWearerPhone">

                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Email:
                                </th>
                                <td id="modalWearerEmail">

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

    <div class="modal fade" id="customerDetails" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Customer Details</h4>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table no-border">
                            <tr>
                                <th>
                                    Wearer ID:
                                </th>
                                <td id="modalCustomerId">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Name:
                                </th>
                                <td id="modalCustomerName">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Phone Number:
                                </th>
                                <td id="modalCustomerPhone">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Email:
                                </th>
                                <td id="modalCustomerEmail">
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

    <div class="modal fade" id="watcherDetails" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Watcher Details</h4>
                </div>

                <div class="modal-body">
                    <h5>Total Wacher(s): &nbsp; <span id="totalWatchersNum"></span></h5>

                    <div class="table-responsive">
                        <table class="table no-border">
                            <thead>
                            <th>
                                Wearer ID
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Phone
                            </th>
                            <th>
                                Email
                            </th>
                            </thead>
                            <tbody id="watchersList">
                            </tbody>
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

    <div class="modal fade" id="addWatcher" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Add Watcher</h4>
                </div>

                <form class="add-new-watcher-form" method="#" action="#">

                    <div class="modal-body">
                        <div class="card card-plain">
                            <input id="modalServiceId" type="text" class="form-control" readonly>

                            <label>Phone Number</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input id="modalWatcherPhoneNum" type="tel" class="form-control" placeholder="Valid phone number" name="watcherPhone" autocomplete="off">
                                        <label id="watcherPhoneNum-error" style="color: #ef8157" class="error wearer-required-error" for="modalWatcherPhoneNum"></label>
                                        <span id="watcher-valid-msg" class="sr-only">✓ Valid</span>
                                        <span id="watcher-error-msg" class="sr-only"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="modalVerifyWatcherPhone" class="btn btn-block btn-outline-info no-margin" disabled="true">
                                        Verify
                                    </div>
                                </div>
                            </div>

                            <div id="modalWatcherFormContainer">
                                <input id="modalWatcherId" type="text" class="form-control" name="watcherId" readonly>
                                <div class="row">
                                    <div class="col-12">
                                        <label>Email</label>
                                        <div class="form-group">
                                            <input id="modalWatcherEmail" type="email" name="watcherEmail" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <label>Name</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="modalWatcherFirstName" type="text" name="watcherFirstName" class="form-control" placeholder="First Name" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="modalWatcherLastName" type="text" name="watcherLastName" class="form-control" placeholder="Last Name" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="left-side">
                            <button type="submit" class="btn btn-link btn-success">
                                <i class="fa fa-plus"></i> &nbsp; Add
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

@endsection

@section('script')
    <script src="/assets/js/services.js" type="text/javascript"></script>
@endsection
