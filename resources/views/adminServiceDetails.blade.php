@extends('layouts.adminApp')

@section('styling')

    <link href="/assets/num_validater/css/intlTelInput.min.css" rel="stylesheet">

@endsection

@section('content')

    <div class="sidebar" data-color="default" data-active-color="danger">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color=" default | primary | info | success | warning | danger |"
      -->
        <div class="logo">
            <a href="https://www.creative-tim.com/" class="simple-text logo-mini">
                <div class="logo-image-small">
                    <img src="/assets/img/logo-small.png">
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
                    <a class="navbar-brand" href="/adminServiceDetails/?id={{$serviceDetails->service_id}}">Service Details</a>
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

        <div id="reloadPage" class="content">
            <div id="reloadContent">
                <div class="row">

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header ">
                                <div class="float-right">
                                    <button id="activateService" data-id="{{$serviceDetails->service_id}}" type="button" class="btn btn-outline-success {{ $serviceDetails->service_status != 'Active' ? '' : 'sr-only' }}">Activate</button>
                                    <button id="deactivateService" data-id="{{$serviceDetails->service_id}}" type="button" class="btn btn-outline-danger {{ $serviceDetails->service_status == 'Active' ? '' : 'sr-only' }}">Deactivate</button>
                                </div>
                                <h4 class="card-title">Service ID: {{$serviceDetails->service_id}}
                                    &nbsp;<span class="badge badge-success {{ $serviceDetails->service_status == 'Active' ? '' : 'sr-only' }}">Active</span>
                                    <span class="badge badge-warning {{ $serviceDetails->service_status == 'Pending' ? '' : 'sr-only' }}">Pending</span>
                                    <span class="badge badge-danger {{ $serviceDetails->service_status == 'Inactive' ? '' : 'sr-only' }}">Inactive</span></h4>
                                <h5 class="card-category">Created On: {{$serviceDetails->created_at}}</h5>
                                <a href="/adminServiceLogs/?id={{$serviceDetails->service_id}}" class="btn btn-outline-primary btn-round btn-sm">View logs</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="nav-tabs-navigation">
                                    <div class="nav-tabs-wrapper">
                                        <ul id="tabs" class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#wearerInfo" role="tab" aria-expanded="true">Wearer Info</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#customerInfo" role="tab" aria-expanded="false">Customer Info</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#watchersInfo" role="tab" aria-expanded="false">Watchers</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div id="my-tab-content" class="tab-content text-center">

                                    <div class="tab-pane active" id="wearerInfo" role="tabpanel" aria-expanded="true">

                                        <div class="table-responsive">
                                            <table class="table no-border">
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Wearer ID:
                                                    </th>
                                                    <td>
                                                        {{$wearerDetails->person_id}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Name:
                                                    </th>
                                                    <td>
                                                        {{$wearerDetails->f_name}} {{$wearerDetails->l_name}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Phone Number:
                                                    </th>
                                                    <td>
                                                        {{$wearerDetails->phone}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Email:
                                                    </th>
                                                    <td>
                                                        {{$wearerDetails->email}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="tab-pane" id="customerInfo" role="tabpanel" aria-expanded="false">

                                        <div class="table-responsive">
                                            <table class="table no-border">
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Customer ID:
                                                    </th>
                                                    <td>
                                                        {{$customerDetails->person_id}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Name:
                                                    </th>
                                                    <td>
                                                        {{$customerDetails->f_name}} {{$customerDetails->l_name}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Phone Number:
                                                    </th>
                                                    <td>
                                                        {{$customerDetails->phone}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="text-left">
                                                        &nbsp;Email:
                                                    </th>
                                                    <td>
                                                        {{$customerDetails->email}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="tab-pane" id="watchersInfo" role="tabpanel" aria-expanded="false">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="float-left" style="margin-top: 12px">
                                                    <h5>Total Watchers: <span>{{$serviceDetails->no_of_watchers}}</span></h5>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="float-right">

                                                    <div id="openAddWatcherForm" data-id="{{$serviceDetails->service_id}}" type="button" class="btn btn-outline-success">
                                                        <i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Add Watcher
                                                    </div>

                                                    <div id="changeProrityOrder" data-id="{{$serviceDetails->service_id}}" type="button" class="btn btn-outline-warning">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Change priority order &nbsp;
                                                        <i style="display: none" id="openChangePriorityLoad" class="fa fa-spinner fa-spin"></i>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="table-responsive">
                                            <table class="table no-border">
                                                <thead class="">
                                                <th>
                                                    Priority
                                                </th>
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
                                                <tbody>
                                                @foreach($watchersList as $wL)
                                                    <tr>
                                                        <td>
                                                            {{$wL->priority_num}}
                                                        </td>
                                                        <td>
                                                            {{$wL->person_id}}
                                                        </td>
                                                        <td>
                                                            {{$wL->f_name}} {{$wL->l_name}}
                                                        </td>
                                                        <td>
                                                            {{$wL->phone}}
                                                        </td>
                                                        <td>
                                                            {{$wL->email}}
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


    <div class="modal fade" id="addWatcher" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Add Watcher</h4>
                </div>

                <form id="addWatcherForm" class="add-new-watcher-form">

                    <div class="modal-body">
                        <div class="card card-plain">
                            <input id="modalServiceId" type="hidden" class="form-control" name="serviceId" placeholder="Service Id" readonly>

                            <label>Phone Number</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input id="modalWatcherStorePhoneNum" type="hidden" class="form-control" name="watcherStorePhone" readonly>
                                        <input id="modalWatcherPhoneNum" type="tel" class="form-control" placeholder="Valid phone number" name="watcherPhone" autocomplete="off">
                                        <label id="watcherPhoneNum-error" style="color: #ef8157" class="error wearer-required-error" for="modalWatcherPhoneNum"></label>
                                        <span id="watcher-valid-msg" class="float-right sr-only">✓ Valid</span>
                                        <span id="watcher-error-msg" class="float-right sr-only"></span>
                                        <span id="watcher-info-msg" class="sr-only"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div id="modalVerifyWatcherPhone" class="btn btn-block btn-outline-info no-margin" disabled="true">
                                        <i id="addWatcherPhoneLoad" class="fa fa-spinner fa-spin" style="display: none ;font-size: 15px"></i> &nbsp; Verify
                                    </div>
                                </div>
                            </div>

                            <div id="modalWatcherFormContainer">
                                <input id="modalWatcherId" type="hidden" class="form-control" name="watcherId" placeholder="Watcher Id" readonly>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Email</label>
                                        <div class="form-group">
                                            <input id="modalWatcherEmail" type="email" name="watcherEmail" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div id="addWatcherEmailLoad" class="row" style="display: none">
                                    <div class="col-12 text-center">
                                        <i class="fa fa-spinner fa-spin" style="font-size: 18px"></i>
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

                                <div class="row">
                                    <div id="modalExistWatcherType" class="sr-only">
                                        <div class="col-12">
                                            <label>Watcher Type</label>
                                            <p id="watcherType" class="font-weight-bold">Responding Watcher</p>
                                        </div>
                                    </div>

                                    <div id="modalNewWatcherType" class="sr-only">
                                        <div class="col-12">
                                            <label>Watcher Type</label><br>
                                            <div class="form-check-radio form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" value="Responding" name="watcherType" checked>
                                                    <span class="form-check-sign"></span>
                                                    Responding
                                                </label>
                                            </div>
                                            <div class="form-check-radio form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" value="Non Responding" name="watcherType">
                                                    <span class="form-check-sign"></span>
                                                    Non responding
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="left-side">
                            <button id="modalAddWatcherSubmit" type="submit" class="btn btn-link btn-success">
                                <i class="fa fa-plus"></i> &nbsp; Add &nbsp; <i style="display: none" id="addWatcherSubmitLoad" class="fa fa-spinner fa-spin"></i>
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


    <div class="modal fade" id="modalChangePriority" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="nc-icon nc-simple-remove"></i>
                    </button>
                    <h4 class="title title-up">Watchers Priority Order</h4>
                    <h4 class="card-category">Drag and drop the list item up or down to change the priority order of watchers</h4>
                </div>

                <div class="modal-body">
                    <div class="card card-plain">
                        <div id="watchersPriorityList" class="list-group">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="left-side">
                        <button data-id="{{$serviceDetails->service_id}}" id="modaSavePriorityOrder" type="button" class="btn btn-link btn-success">
                            <i class="fa fa-save"></i> &nbsp; Save Order &nbsp; <i style="display: none" id="modaSavePriorityOrderLoad" class="fa fa-spinner fa-spin"></i>
                        </button>
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

    <!--  Plugin for Sweet Alert -->
    <script src="/assets/js/plugins/sweetalert2.min.js"></script>

    <script src="/assets/js/serviceDetails.js" type="text/javascript"></script>


    <script src="/assets/num_validater/js/intlTelInput-jquery.min.js"></script>
    <script src="/assets/num_validater/js/data.min.js"></script>
    <script src="/assets/num_validater/js/intlTelInput.js"></script>
    <script src="/assets/num_validater/js/utils.js"></script>

@endsection
