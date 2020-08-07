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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <form style="margin-top: 10px">
                                        <div class="input-group no-border">
                                            <input type="text" value="" class="form-control" placeholder="Search services">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <i class="nc-icon nc-zoom-split"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
                                    <tbody>
                                    <tr>
                                        <td class="text-center">
                                            WOMS00000694
                                        </td>
                                        <td>
                                            123456789
                                        </td>
                                        <td class="link-text customer-name" data-toggle="modal" data-target="#wearerDetails">
                                            Usama Waheed
                                        </td>
                                        <td class="link-text customer-name" data-toggle="modal" data-target="#customerDetails">
                                            Rad Williams
                                        </td>
                                        <td class="link-text customer-name text-center" data-toggle="modal" data-target="#watcherDetails">
                                            <b class="link-text watcher-num">3</b>
                                        </td>
                                        <td class="text-center">
                                            Activated
                                        </td>
                                        <td class="text-right">
                                            <button type="button" rel="tooltip" class="btn btn-outline-default btn-round btn-sm">
                                                Details
                                            </button>
                                        </td>
                                    </tr>
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
                                <td>
                                    WOMP00000875
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Name:
                                </th>
                                <td>
                                    Usama Waheed
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Phone Number:
                                </th>
                                <td>
                                    0403887321
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Email:
                                </th>
                                <td>
                                    usamaw94@gmail.com
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
                                <td>
                                    WOMP00000875
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Name:
                                </th>
                                <td>
                                    Usama Waheed
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Phone Number:
                                </th>
                                <td>
                                    0403887321
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Email:
                                </th>
                                <td>
                                    usamaw94@gmail.com
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
                    <h5>Total Wachers: <span>3</span></h5>

                    <div class="table-responsive">
                        <table class="table no-border">
                            <thead class="">
                            <th>
                                Wearer ID
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Phone
                            </th>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    WOMP00000876
                                </td>
                                <td>
                                    Waqas Waheed
                                </td>
                                <td>
                                    0435533452
                                </td>
                                <td>
                                    waqax94@gmail.com
                                </td>
                            </tr>
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

@endsection

@section('script')

@endsection
