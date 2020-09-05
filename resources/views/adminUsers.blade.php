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
                    <a class="navbar-brand" href="/adminUsers">Users</a>
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
                                <div class="col-md-12">
                                    <div style="margin-top: 10px">
                                        <div class="input-group no-border">
                                            <input type="text" id="usersSearchText" class="form-control" placeholder="Search users">
                                            <div id="searchUsers" class="input-group-append btn btn-default">
                                                <i style="font-size: 16px" class="nc-icon nc-zoom-split"></i>
                                                &nbsp;&nbsp;
                                                <span id="usersSearchLoad" class="sr-only"><i class="fa fa-refresh fa-spin"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="pull-right">
                                <div id="userSearchControl" class="sr-only">
                                    Total users: &nbsp;<b id="noOfUsers"></b> &nbsp;&nbsp; <a href="/adminUsers" class="btn btn-outline-default">Reset search</a>
                                </div>
                                <div id="usersPaginationContainer">
                                    Showing {{($users->currentPage()-1)* $users->perPage() + 1}} to
                                    {{ ($users->currentPage()-1)* $users->perPage() + $users->perPage() }} of
                                    {{ $users->total() }} users &nbsp;
                                    <a href="{{ $users->previousPageUrl() }}" class="btn btn-outline-default btn-sm btn-icon btn-round">
                                        <i class="fa fa-angle-left" style="font-size: 25px" aria-hidden="true"></i>
                                    </a>
                                    <a href="{{ $users->nextPageUrl() }}" class="btn btn-outline-default btn-sm btn-icon btn-round">
                                        <i class="fa fa-angle-right" style="font-size: 25px" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <h4 class="card-title"> Users List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                    <th class="text-center">
                                        User Id
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Phone Number
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th class="text-center">
                                        Actions
                                    </th>
                                    </thead>
                                    <tbody id="showUserList">
                                    @foreach($users as $usr)
                                    <tr>
                                        <td class="text-center">
                                            {{ $usr->person_id }}
                                        </td>
                                        <td>
                                            {{ $usr->full_name }}
                                        </td>
                                        <td>
                                            {{ $usr->phone }}
                                        </td>
                                        <td>
                                            {{ $usr->email }}
                                        </td>
                                        <td class="text-center">
                                            <a target="_blank" href="/adminUserDetails?id={{$usr->person_id}}" type="button" rel="tooltip" class="btn btn-outline-default btn-round btn-sm">
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

@endsection

@section('script')

    <script src="/assets/js/users.js" type="text/javascript"></script>

@endsection

