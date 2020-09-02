@extends('layouts.userApp')

@section('styling')

    <link href="/userAssets/num_validater/css/intlTelInput.min.css" rel="stylesheet">

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
                <li class="nav-item ">
                    <a class="nav-link" href="/userAsWatcher">
                        <i class="material-icons">settings</i>
                        <p> As watcher </p>
                    </a>
                </li>
                <li class="nav-item active">
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
                    <a class="navbar-brand" href="javascript:;">Service details</a>
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
            <div id="reloadContent" class="container-fluid">


                <div class="row">

                        <div class="col-12">

                            <div class="card">
                                <div class="card-header card-header-text card-header-primary">
                                    <div class="card-text">
                                        <h4 class="card-title">Service ID: {{$serviceDetails->service_id}}</h4>
                                        <!--                      <p class="card-category">Created On: 02/03/2019 - 3:27:45 Pm</p>-->
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="pull-right">
                                        <p>
                                            <span class="badge badge-success {{ $serviceDetails->service_status == 'Active' ? '' : 'sr-only' }}">Active</span>
                                            <span class="badge badge-warning {{ $serviceDetails->service_status == 'Pending' ? '' : 'sr-only' }}">Pending</span>
                                            <span class="badge badge-danger {{ $serviceDetails->service_status == 'Inactive' ? '' : 'sr-only' }}">Inactive</span>
                                            <span class="badge badge-default {{ $serviceDetails->service_status == 'User Verification Required' ? '' : 'sr-only' }}">Verification Required</span>
                                        </p>
                                    </div>
                                    <p>Created On: {{$serviceDetails->created_at}}</p>
                                    <a href="/adminServiceLogs/?id={{$serviceDetails->service_id}}" class="btn btn-outline-info">
                                        <i class="material-icons">remove_red_eye</i>
                                        &nbsp; View service logs
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                <div class="row">
                        <div class="col-12">
                            <div class="page-categories">
                                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#wearer" role="tablist">
                                            <i class="material-icons">account_circle</i> Wearer
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#watchers" role="tablist">
                                            <i class="material-icons">supervisor_account</i> Watchers
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#customer" role="tablist">
                                            <i class="material-icons">assignment_ind</i> Customer
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content tab-space tab-subcategories">

                                    <div class="tab-pane active" id="wearer">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <td class="text-left">
                                                                <b>Wearer ID:</b>
                                                            </td>
                                                            <td>
                                                                {{$wearerDetails->person_id}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">
                                                                &nbsp;<b>Name:</b>
                                                            </td>
                                                            <td>
                                                                {{$wearerDetails->full_name}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">
                                                                &nbsp;<b>Phone Number:</b>
                                                            </td>
                                                            <td>
                                                                {{$wearerDetails->phone}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">
                                                                &nbsp;<b>Email:</b>
                                                            </td>
                                                            <td>
                                                                {{$wearerDetails->email}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">
                                                                &nbsp;<b>Verification Status:</b>
                                                            </td>
                                                            <td>
                                                                @if($wearerDetails->verification_status == 'true')

                                                                    <span class='badge badge-success'>
                                                                        <i class='fa fa-check'></i>
                                                                        &nbsp; Verified
                                                                    </span>

                                                                @elseif($wearerDetails->verification_status == 'true')

                                                                    <span class='badge badge-default'>
                                                                        <i class='fa fa-info'></i>
                                                                        &nbsp; Verification Required
                                                                    </span>

                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="watchers">
                                        <div class="card">
                                            <div class="card-body">
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

                                                            <div id="changeProrityOrder" type="button" data-id="{{$serviceDetails->service_id}}" class="btn btn-outline-warning">
                                                                <i class="fa fa-pencil" aria-hidden="true"></i> &nbsp; Change priority order &nbsp;
                                                                <i style="display: none" id="openChangePriorityLoad" class="fa fa-spinner fa-spin"></i>
                                                            </div>

                                                        </div>

                                                    </div>


                                                </div>


                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="text-muted">
                                                        <tr>
                                                            <th>
                                                                Priority Order
                                                            </th>
                                                            <th>
                                                                Watcher ID
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
                                                            <th>
                                                                Verification Status
                                                            </th>
                                                        </tr>
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
                                                                    {{$wL->full_name}}
                                                                </td>
                                                                <td>
                                                                    {{$wL->phone}}
                                                                </td>
                                                                <td>
                                                                    {{$wL->email}}
                                                                </td>
                                                                <td>
                                                                    @if($wL->verification_status == 'true')

                                                                        <span class='badge badge-success'>
                                                                            <i class='fa fa-check'></i>
                                                                            &nbsp; Verified
                                                                        </span>

                                                                    @elseif($wL->verification_status == 'false')

                                                                        <span class='badge badge-default'>
                                                                            <i class='fa fa-info'></i>
                                                                            &nbsp; Verification Required
                                                                        </span>

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

                                    <div class="tab-pane" id="customer">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table no-border">
                                                        <tr>
                                                            <td class="text-left">
                                                                &nbsp;<b>Customer ID:</b>
                                                            </td>
                                                            <td>
                                                                {{$customerDetails->person_id}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">
                                                                &nbsp;<b>Name:</b>
                                                            </td>
                                                            <td>
                                                                {{$customerDetails->full_name}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">
                                                                &nbsp;<b>Phone Number:</b>
                                                            </td>
                                                            <td>
                                                                {{$customerDetails->phone}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">
                                                                <b>Email:</b>
                                                            </td>
                                                            <td>
                                                                {{$customerDetails->email}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">
                                                                <b>Verification Status:</b>
                                                            </td>
                                                            <td>
                                                                @if($customerDetails->verification_status == 'true')

                                                                    <span class='badge badge-success'>
                                                                            <i class='fa fa-check'></i>
                                                                            &nbsp; Verified
                                                                        </span>

                                                                @elseif($customerDetails->verification_status == 'false')

                                                                    <span class='badge badge-default'>
                                                                            <i class='fa fa-info'></i>
                                                                            &nbsp; Verification Required
                                                                        </span>

                                                                @endif
                                                            </td>
                                                        </tr>
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

        <div class="modal fade" id="addWatcher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="personModalTitle" class="modal-title">Add new Watcher</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>
                    <form id="addWatcherForm" class="add-new-watcher-form">
                        <div class="modal-body">
                            <input id="modalServiceId" type="hidden" class="form-control" name="serviceId" placeholder="Service Id" readonly>

                            <div class="row justify-content-center">
                                <div class="col-lg-8 col-md-8">
                                    <div class="bmd-form-group">
                                        <input id="modalWatcherStorePhoneNum" type="hidden" class="form-control" name="watcherStorePhone" readonly>
                                        <input id="modalWatcherPhoneNum" type="tel" class="form-control" placeholder="Valid phone number" name="watcherPhone" autocomplete="off">
                                        <label id="watcherPhoneNum-error" style="color: #ef8157" class="error wearer-required-error" for="modalWatcherPhoneNum"></label>
                                        <span id="watcher-valid-msg" class="float-right sr-only">✓ Valid</span>
                                        <span id="watcher-error-msg" class="float-right sr-only"></span>
                                        <span id="watcher-info-msg" class="sr-only"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button id="modalVerifyWatcherPhone" class="btn btn-block btn-outline-info btn-sm" disabled="true">
                                        <i id="addWatcherPhoneLoad" class="fa fa-spinner fa-spin" style="display: none ;font-size: 15px"></i> &nbsp; Verify
                                    </button>
                                </div>
                            </div>
                            <br>
                            <div id="modalWatcherFormContainer">
                                <input id="modalWatcherId" type="hidden" class="form-control" name="watcherId" placeholder="Watcher Id" readonly>

                                <div class="row sr-only" id="modalNewEmail">
                                    <div class="col-md-12">
                                        <div class="input-group no-border">
                                            <input id="modalNewWatcherEmail" type="text" name="watcherNewEmail" class="form-control" placeholder="Enter valid email address">
                                            <button id="modalVerifyEmail" class="input-group-append btn btn-info btn-sm btn-link">
                                                <i id="addWatcherEmailLoad" class="fa fa-spinner fa-spin" style="display: none ; margin-top: 0px;font-size: 15px"></i> &nbsp; Verify
                                            </button>
                                        </div>
                                        <span id="watcher-email-info-msg" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="row sr-only" id="modalExistEmail">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input id="modalWatcherEmail" type="email" name="watcherEmail" class="form-control" placeholder="Email" readonly>
                                        </div>
                                    </div>
                                </div>
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
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="watcherType" value="Responding" checked> Responding
                                                    <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="watcherType" value="Non Responding"> Non responding
                                                    <span class="circle">
                                                    <span class="check"></span>
                                                </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="modalAddWatcherSubmit" type="submit" class="btn btn-link btn-success">
                                <i class="fa fa-plus"></i> &nbsp; Add &nbsp; <i style="display: none" id="addWatcherSubmitLoad" class="fa fa-spinner fa-spin"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalChangePriority" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="personModalTitle" class="modal-title">Watchers Priority Order</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted text-sm-left">Drag and drop the list items up or down to change the priority order of watchers</p>
                        <div id="watchersPriorityList" class="list-group">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-id="{{$serviceDetails->service_id}}" id="modalBtnSavePriorityOrder" type="submit" class="btn btn-link btn-success">
                            <i class="fa fa-save"></i> &nbsp; Save Order &nbsp; <i style="display: none" id="modaSavePriorityOrderLoad" class="fa fa-spinner fa-spin"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')

    <!--  Plugin for Sweet Alert -->
    <script src="/userAssets/js/plugins/sweetalert2.js"></script>

    <script src="/userAssets/js/userAsCustomerService.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="/userAssets/js/plugins/jquery.validate.min.js"></script>
    <script src="/userAssets/num_validater/js/intlTelInput-jquery.min.js"></script>
    <script src="/userAssets/num_validater/js/data.min.js"></script>
    <script src="/userAssets/num_validater/js/intlTelInput.js"></script>
    <script src="/userAssets/num_validater/js/utils.js"></script>

@endsection

