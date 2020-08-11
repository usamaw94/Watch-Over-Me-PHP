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
                    <img src="assets/img/logo-small.png">
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

        <div class="content">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header ">
                            <h4 class="card-title">Service ID: {{$serviceDetails->service_id}}</h4>
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
    <script src="assets/js/services.js" type="text/javascript"></script>

@endsection
