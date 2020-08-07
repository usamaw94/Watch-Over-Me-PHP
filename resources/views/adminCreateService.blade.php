@extends('layouts.adminApp')

@section('styling')
{{--    <link href="assets/num_validater/css/demo.css" rel="stylesheet">--}}
    <link href="assets/num_validater/css/intlTelInput.min.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="javascript:;">Create Service</a>
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
            <div class="col-md-10 mr-auto ml-auto">
                <!--      Wizard container        -->
                <div class="wizard-container">
                    <div class="card card-wizard" data-color="primary" id="wizardProfile">
                        <form action="#" method="">
                            <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                            <div class="card-header text-center">
                                <h3 class="card-title">
                                    Create New Service
                                </h3>
                                <!--                <h5 class="description"></h5>-->
                                <div class="wizard-navigation">
                                    <ul>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#wearerTab" data-toggle="tab" role="tab" aria-controls="about" aria-selected="true">
                                                <i class="nc-icon nc-circle-10"></i>
                                                Wearer
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#watcherTab" data-toggle="tab" role="tab" aria-controls="account" aria-selected="true">
                                                <i class="nc-icon nc-single-02"></i>
                                                Watcher
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#customerTab" data-toggle="tab" role="tab" aria-controls="address" aria-selected="true">
                                                <i class="nc-icon nc-single-02"></i>
                                                Customer
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#summaryTab" data-toggle="tab" role="tab" aria-controls="address" aria-selected="true">
                                                <i class="nc-icon nc-bullet-list-67"></i>
                                                Summary
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">

                                    <div class="tab-pane show active" id="wearerTab">
                                        <h5 class="info-text"> Enter Wearer Information</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-7 col-md-8">
                                                <input id="wearerPhoneNum" type="tel" class="form-control" style="padding: 10px" name="wearerPhone" placeholder="Valid phone number" autocomplete="off">
                                                <label id="wearerPhoneNum-error" style="color: #ef8157" class="error wearer-required-error" for="wearerPhoneNum"></label>
                                                <span id="valid-msg" class="float-right sr-only">✓ Valid</span>
                                                <span id="error-msg" class="float-right sr-only"></span>
                                                <span id="wearer-info-msg" class="text-warning font-weight-bold sr-only"></span>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div id="wearerCheckNumberBtn" class="btn btn-outline-info btn-block btn-round no-margin" disabled="true">
                                                    Check
                                                </div>
                                            </div>

                                            <br>

                                            <input type="hidden" id="wearerDetailsFormCheck" value="hide" readonly>
                                            <input type="hidden" id="wearerStorePhoneNum" name="wearerStorePhoneNum" readonly>
                                            <input type="hidden" id="existStatus" name="existStatus" readonly>
                                            <input type="hidden" id="wearerId" name="wearerId" readonly>
                                            <div id="wearerDetailsForm" class="col-lg-10 mt-3">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="nc-icon nc-single-02"></i></span>
                                                            </div>
                                                            <input id="wearerFirstName" type="text" class="form-control" placeholder="First Name (required)" name="wearerFirstName">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="nc-icon nc-circle-10"></i></span>
                                                            </div>
                                                            <input id="wearerLastName" type="text" placeholder="Last Name (required)" class="form-control" name="wearerLastName" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="nc-icon nc-email-85"></i></span>
                                                            </div>
                                                            <input id="wearerEmail" type="text" class="form-control" placeholder="Email (required)" name="wearerEmail">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-pane show" id="watcherTab">
                                        <h5 class="info-text"> Enter Watcher Information</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-7 col-md-8">
                                                <input id="watcherPhoneNum" type="tel" class="form-control" style="padding: 10px" name="watcherPhone" placeholder="Valid phone number" autocomplete="off">
                                                <label id="watcherPhoneNum-error" style="color: #ef8157" class="error wearer-required-error" for="watcherPhoneNum"></label>
                                                <span id="watcher-valid-msg" class="sr-only">✓ Valid</span>
                                                <span id="watcher-error-msg" class="sr-only"></span>
                                            </div>
                                            <div class="col-lg-3 col-md-4">
                                                <div id="watcherCheckNumberBtn" class="btn btn-outline-info btn-block btn-round no-margin" disabled="true">
                                                    Check
                                                </div>
                                            </div>

                                            <br>

                                            <input type="hidden" id="watcherDetailsFormCheck" value="hide" readonly>
                                            <div id="watcherDetailsForm" class="col-lg-10 mt-3">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="nc-icon nc-single-02"></i></span>
                                                            </div>
                                                            <input id="watcherFirstName" type="text" class="form-control" placeholder="First Name (required)" name="watcherFirstName">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="nc-icon nc-circle-10"></i></span>
                                                            </div>
                                                            <input id="watcherLastName" type="text" placeholder="Last Name (required)" class="form-control" name="watcherLastName" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="nc-icon nc-email-85"></i></span>
                                                            </div>
                                                            <input id="watcherEmail" type="text" class="form-control" placeholder="Email (required)" name="watcherEmail">
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-dark font-italic">* More watcher can be added after service registration</p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-pane" id="customerTab">
                                        <h5 class="info-text">Customer will be </h5>
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div id="wearerCustomer" class="choice" data-toggle="wizard-radio">
                                                            <input type="radio" name="jobb" value="Design">
                                                            <div class="icon">
                                                                <i class="nc-icon nc-circle-10"></i>
                                                            </div>
                                                            <h6>Wearer</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div id="watcherCustomer" class="choice" data-toggle="wizard-radio">
                                                            <input type="radio" name="jobb" value="Code">
                                                            <div class="icon">
                                                                <i class="nc-icon nc-single-02"></i>
                                                            </div>
                                                            <h6>Watcher</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div id="otherCustomer" class="choice" data-toggle="wizard-radio">
                                                            <input type="radio" name="jobb" value="Code">
                                                            <div class="icon">
                                                                <i class="nc-icon nc-single-02"></i>
                                                            </div>
                                                            <h6>Other</h6>
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>

                                                <div id="otherCustomerTab">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-7 col-md-8">
                                                            <input id="customerPhoneNum" type="tel" class="form-control" style="padding: 10px" name="customerPhone" placeholder="Valid phone number" autocomplete="off">
                                                            <label id="customerPhoneNum-error" style="color: #ef8157" class="error customer-required-error" for="customerPhoneNum"></label>
                                                            <span id="customer-valid-msg" class="sr-only">✓ Valid</span>
                                                            <span id="customer-error-msg" class="sr-only"></span>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4">
                                                            <div id="customerCheckNumberBtn" class="btn btn-outline-info btn-block btn-round no-margin" disabled="true">
                                                                Check
                                                            </div>
                                                        </div>

                                                        <br>

                                                        <input type="hidden" id="customerDetailsFormCheck" value="hide" readonly>
                                                        <div id="customerDetailsForm" class="col-lg-10 mt-3">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="nc-icon nc-single-02"></i></span>
                                                                        </div>
                                                                        <input id="customerFirstName" type="text" class="form-control" placeholder="First Name (required)" name="customerFirstName">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="nc-icon nc-circle-10"></i></span>
                                                                        </div>
                                                                        <input id="customerLastName" type="text" placeholder="Last Name (required)" class="form-control" name="customerLastName" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="nc-icon nc-email-85"></i></span>
                                                                        </div>
                                                                        <input id="customerEmail" type="text" class="form-control" placeholder="Email (required)" name="customerEmail">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="summaryTab">
                                        <h5 class="info-text">Form Summary</h5>
                                        <div class="row justify-content-center">

                                            <div class="col-lg-10">
                                                <h6>Wearer Details</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>
                                                                Name:
                                                            </th>
                                                            <td id="wearerSummaryName">
                                                                Usama Waheed
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                Phone Number:
                                                            </th>
                                                            <td id="wearerSummaryPhone">
                                                                +61403887321
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                Email:
                                                            </th>
                                                            <td id="wearerSummaryEmail">
                                                                usamaw94@gmail.com
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-lg-10">
                                                <h6>Watcher Details</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>
                                                                Name:
                                                            </th>
                                                            <td id="watcherSummaryName">
                                                                Usama Waheed
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                Phone Number:
                                                            </th>
                                                            <td id="watcherSummaryPhone">
                                                                +61403887321
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                Email:
                                                            </th>
                                                            <td id="watcherSummaryEmail">
                                                                usamaw94@gmail.com
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-lg-10">
                                                <h6>Customer Details</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>
                                                                Name:
                                                            </th>
                                                            <td id="customerSummaryName">
                                                                Usama Waheed
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                Phone Number:
                                                            </th>
                                                            <td id="customerSummaryPhone">
                                                                +61403887321
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                Email:
                                                            </th>
                                                            <td id="customerSummaryEmail">
                                                                usamaw94@gmail.com
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <p class="font-italic info-text"><strong>Wearer will be customer</strong></p>
                                                <p class="font-italic info-text"><strong>Watcher will be customer</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="pull-right">
                                    <input id="nextTab" disabled="true" type='button' class='btn btn-next btn-fill btn-rose btn-wd' name='next' value='Next' />
                                    <input id="submitForm" type='button' class='btn btn-finish btn-fill btn-rose btn-wd' name='finish' value='Submit' />
                                </div>
                                <div class="pull-left">
                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div> <!-- wizard container -->
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
    <script src="assets/js/createService.js" type="text/javascript"></script>
    <script src="assets/num_validater/js/intlTelInput-jquery.min.js"></script>
    <script src="assets/num_validater/js/data.min.js"></script>
    <script src="assets/num_validater/js/intlTelInput.js"></script>
    <script src="assets/num_validater/js/utils.js"></script>
@endsection
