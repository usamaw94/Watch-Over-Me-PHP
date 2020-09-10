<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Watch Over Me</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

    <link href="/webAssets/img/womfavicon.png" rel="icon">
    <link href="/webAssets/img/womfavicon.png" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <link href="/webAssets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/webAssets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="/webAssets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/webAssets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/webAssets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="/webAssets/vendor/aos/aos.css" rel="stylesheet">

    <link href="/webAssets/css/style.css" rel="stylesheet">

</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top  header-transparent ">
    <div class="container d-flex align-items-center">

        <div class="logo mr-auto">
            <a href="index.html"><img src="webAssets/img/womcoloricon.png" alt="WOM" class="img-fluid"></a>
        </div>


        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="active"><a href="index.html">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#gallery">App Insights</a></li>
                <li class="get-started">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}">{{ Auth::user()->full_name }}</a>
                        @else
                            <a href="{{ route('login') }}">Login</a>
                        @endauth
                    @endif
                </li>
            </ul>
        </nav><!-- .nav-menu -->

    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-5 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
                <div>
                    <h1>Watch Over ME</h1>
                    <h2>We help you watch out for your loved ones</h2>
                </div>
            </div>
            <div class="col-lg-7 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
                <img src="webAssets/img/LandingHome-min.png" class="img-fluid hero-img-shadow" alt="">
            </div>
        </div>
    </div>

</section><!-- End Hero -->

<main id="main">

    <!-- ======= App Features Section ======= -->
    <section id="about" class="features">
        <div class="container">

            <div class="section-title">
                <h2>About</h2>
                <p><b>Watch Over Me</b> is aimed to help the caretakers/Watchers of the old age people and dementia patients/Wearers. Using this platform, caretakers will be able to monitor the activities of there loved ones and enable them to respond promptly in emergency situations.</p>
            </div>

            <div class="row no-gutters">
                <div class="col-xl-8 d-flex align-items-stretch order-2 order-lg-1">
                    <div class="content d-flex flex-column justify-content-center">
                        <div class="row">
                            <div class="col-md-6 icon-box" data-aos="fade-up">
                                <i class="bx bx-current-location"></i>
                                <h4>Current location tracking</h4>
                                <p>Watchers can access the current location of their wearers at any time</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                                <i class="bx bx-alarm"></i>
                                <h4>Regular location logs</h4>
                                <p>Application will record the wearer location history on hourly basis.</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                                <i class="bx bx-info-circle"></i>
                                <h4>Help Me Request</h4>
                                <p>Wearer can activate Help Me Request in emergency situation. This system will notify all the responding watchers in a priority manner.</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                                <i class="bx bx-list-ul"></i>
                                <h4>Help Me Request Timeline</h4>
                                <p>Watchers can view the Help Me Request timeline through their web panel.</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                                <i class="bx bx-message-detail"></i>
                                <h4>SMS, Email and Call Alerts</h4>
                                <p>Once Help Me Request is triggered, then watchers will be contacted via <strong>SMS</strong>, <strong>Email</strong> and <strong>Phone call</strong>.</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                                <i class="bx bx-user-plus"></i>
                                <h4>Multiple watchers</h4>
                                <p>Upto 8 watchers can be added for a single wearer with changeable priority order.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="image offset-1 col-xl-3 d-flex justify-content-center order-1 order-lg-2 " data-aos="fade-left" data-aos-delay="100">
                    <img src="webAssets/img/womiconround.png" class="img-fluid purple-logo" alt="">
                </div>
            </div>

        </div>
    </section><!-- End App Features Section -->

    <!-- ======= Details Section ======= -->
    <section id="details" class="details">
        <div class="container">

            <div class="row content">
                <div class="col-md-4" data-aos="fade-right">
                    <img src="webAssets/img/gallery/HomeActive.jpg" class="img-fluid img-wearer-app-sec img-shadow" alt="">
                </div>
                <div class="col-md-8 pt-4" data-aos="fade-up">
                    <h3>Watch Over ME - Wearer Application</h3>
                    <p class="font-italic">
                        WOM app will run on the wearer's phone and it provide multiple features.
                    </p>
                    <ul>
                        <li><i class="icofont-check"></i> Initiate Help Me Request.</li>
                        <li><i class="icofont-check"></i> Follow up Help Me Request progress.</li>
                        <li><i class="icofont-check"></i> Speeddial option to call watchers.</li>
                    </ul>
                    <p>
                        Wearer application will continue to run in the background so that it can monitor wearer all the time
                    </p>
                </div>
            </div>

            <div class="row content">
                <div class="col-md-6 order-2 order-md-1 pt-5" data-aos="fade-up">
                    <h3>WOM - Customer Web Panel</h3>
                    <p class="font-italic">
                        Customer will be the one to pay for the service. He/She cab either be wearer or watcher. System will enable the customer to control multiple operations of the service.
                    </p>
                    <ul>
                        <li><i class="icofont-check"></i> Track wearer current location.</li>
                        <li><i class="icofont-check"></i> View weaerer location logs.</li>
                        <li><i class="icofont-check"></i> View Help Me Request timeline.</li>
                        <li><i class="icofont-check"></i> Add new watcher in the service.</li>
                        <li><i class="icofont-check"></i> Change the priority order of watchers.</li>
                    </ul>
                </div>
                <div class="col-md-6 order-1 order-md-2" data-aos="fade-left">
                    <img src="webAssets/img/Customer.jpg" class="img-fluid img-shadow" alt="">
                </div>
            </div>

            <div class="row content">
                <div class="col-md-6" data-aos="fade-right">
                    <img src="webAssets/img/Watcher.jpg" class="img-fluid img-shadow" alt="">
                </div>
                <div class="col-md-6 pt-5" data-aos="fade-up">
                    <h3>WOM - Watcher Web Panel</h3>
                    <p class="font-italic">Watcher will be main person to respond in emergency situation.</p>
                    <ul>
                        <li><i class="icofont-check"></i> Track wearer current location.</li>
                        <li><i class="icofont-check"></i> View weaerer location logs.</li>
                        <li><i class="icofont-check"></i> Respond to Help Me Request.</li>
                        <li><i class="icofont-check"></i> View Help Me Request timeline.</li>
                    </ul>
                </div>
            </div>

        </div>
    </section><!-- End Details Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
        <div class="container">

            <div class="section-title">
                <h2>App Insights</h2>
            </div>

            <div class="owl-carousel gallery-carousel" data-aos="fade-up">
                <a data-gall="gallery-carousel"><img src="webAssets/img/gallery/HomeActive.jpg" alt=""></a>
                <a data-gall="gallery-carousel"><img src="webAssets/img/gallery/HelpMeInitiate.jpg" alt=""></a>
                <a data-gall="gallery-carousel"><img src="webAssets/img/gallery/Notifications.jpg" alt=""></a>
                <a data-gall="gallery-carousel"><img src="webAssets/img/gallery/Notifications2.jpg" alt=""></a>
                <a data-gall="gallery-carousel"><img src="webAssets/img/gallery/Watchers.jpg" alt=""></a>
                <a data-gall="gallery-carousel"><img src="webAssets/img/gallery/Login.jpg" alt=""></a>
            </div>

        </div>
    </section><!-- End Gallery Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">

    <div class="container py-4">
        <div class="copyright">
            &copy; Copyright <strong><span>Watch Over Me</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Powered by <a href="">UAW Dev Studios</a>
        </div>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<!-- Vendor JS Files -->
<script src="/webAssets/vendor/jquery/jquery.min.js"></script>
<script src="/webAssets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/webAssets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="/webAssets/vendor/php-email-form/validate.js"></script>
<script src="/webAssets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="/webAssets/vendor/venobox/venobox.min.js"></script>
<script src="/webAssets/vendor/aos/aos.js"></script>

<!-- Template Main JS File -->
<script src="/webAssets/js/main.js"></script>

</body>

</html>
