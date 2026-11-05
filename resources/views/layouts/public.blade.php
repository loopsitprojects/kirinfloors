<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <title>@yield('title', 'Kirin Flooring | Premium SPC & Click-Lock Flooring')</title>

    @php
        $canonicalUrl = url()->current();
        $canonicalHost = parse_url($canonicalUrl, PHP_URL_HOST);

        if ($canonicalHost && ! str_starts_with($canonicalHost, 'www.')) {
            $canonicalUrl = str_replace('://' . $canonicalHost, '://www.' . $canonicalHost, $canonicalUrl);
        }
    @endphp
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <meta property="og:image" content="{{ asset('assets/img/kirin_og.jpg') }}">
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    @yield('meta')

    <!--Favicon-->
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="icon" href="{{ asset('favicon-48.png') }}" type="image/png" sizes="48x48">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Line Awesome CSS -->
    <link href="{{ asset('assets/css/line-awesome.min.css') }}" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="{{ asset('assets/css/fontAwesomePro.css') }}" rel="stylesheet">
    <!-- Animate CSS-->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <!-- Bar Filler CSS -->
    <link href="{{ asset('assets/css/barfiller.css') }}" rel="stylesheet">
    <!-- Magnific Popup Video -->
    <link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">
    <!-- Flaticon CSS -->
    <link href="{{ asset('assets/css/flaticon.css') }}" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link href="{{ asset('assets/css/owl.carousel.css') }}" rel="stylesheet">
    <!-- Slick Slider CSS -->
    <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet">
    <!-- Nice Select  -->
    <link href="{{ asset('assets/css/nice-select.css') }}" rel="stylesheet">
    <!-- Back to Top -->
    <link href="{{ asset('assets/css/backToTop.css') }}" rel="stylesheet">
    <!-- Metis Menu -->
    <link href="{{ asset('assets/css/metismenu.css') }}" rel="stylesheet">
    <!-- Odometer CSS -->
    <link href="{{ asset('assets/css/odometer.min.css') }}" rel="stylesheet">
    <!-- FancyBox CSS -->
    <link href="{{ asset('assets/css/fancy-box.min.css') }}" rel="stylesheet">
    <!-- Style CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5TR2NRB5');</script>
<!-- End Google Tag Manager -->

    @yield('styles')
</head>

<Style>
    :root {
        --brand-gold: #D8B463;
        --brand-dark: #111111;
        --brand-light: #F8F8F8;
        --brand-gray: #333333;
    }

    .navbar-brand img {
        width: 26%
    }

    /* Force all social icons to sit in one horizontal row */
    .social-area-wrap {
        display: flex;
        flex-wrap: nowrap;
        /* keep on one line */
        gap: 12px;
        /* space between icons */
        justify-content: center;
        /* center them inside the container */
        align-items: center;
    }

    .social-area-wrap a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        /* consistent button size */
        height: 32px;
        border-radius: 50%;
        /* keeps the circle look */
    }

    #cart-count {
        font-size: 0.65rem;
        padding: 0.2em 0.5em;
        border: 1px solid white;
    }

    /* Keep the header's space when it turns sticky (position: fixed). Otherwise the
       page shrinks by 100px, and short pages flicker as it switches on and off. */
    #header-1 {
        min-height: 100px;
    }

    .nav-icon {
        color: #fff;
        font-size: 1.2rem;
        margin-left: 1.5rem;
        transition: color 0.3s ease;
    }

    .nav-icon:hover {
        color: var(--brand-gold);
    }

    /* Floating Social Media Widget */
    .floating-social-widget {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 999;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .social-icon-float {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--brand-gold);
        color: white;
        font-size: 1.3rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .social-icon-float:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(216, 180, 99, 0.4);
        color: white;
    }

    .social-icon-float.facebook {
        background: #1877f2;
    }

    .social-icon-float.instagram {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    }

    .social-icon-float.whatsapp {
        background: #25d366;
    }

    .social-icon-float.linkedin {
        background: #0077b5;
    }

    .social-icon-float.twitter {
        background: #1da1f2;
    }

    @media (max-width: 768px) {
        .floating-social-widget {
            bottom: 20px;
            right: 20px;
        }

        .social-icon-float {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }
    }

    /* Cookie Policy Widget */
    .cookie-consent-banner {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(17, 17, 17, 0.98);
        color: white;
        padding: 20px;
        z-index: 9999;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
        transform: translateY(100%);
        transition: transform 0.4s ease-in-out;
    }

    .cookie-consent-banner.show {
        transform: translateY(0);
    }

    .cookie-consent-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .cookie-consent-text {
        flex: 1;
        min-width: 250px;
    }

    .cookie-consent-text p {
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .cookie-consent-text a {
        color: var(--brand-gold);
        text-decoration: underline;
    }

    .cookie-consent-text a:hover {
        color: #e6c580;
    }

    .cookie-consent-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .cookie-btn {
        padding: 10px 24px;
        border: none;
        border-radius: 4px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .cookie-btn-accept {
        background: var(--brand-gold);
        color: white;
    }

    .cookie-btn-accept:hover {
        background: #c9a555;
        transform: translateY(-2px);
    }

    .cookie-btn-decline {
        background: transparent;
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .cookie-btn-decline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.5);
    }

    @media (max-width: 768px) {
        .cookie-consent-content {
            flex-direction: column;
            text-align: center;
        }

        .cookie-consent-actions {
            width: 100%;
            justify-content: center;
        }

        .cookie-btn {
            flex: 1;
            min-width: 120px;
        }
    }
</Style>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5TR2NRB5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <!-- Pre-Loader -->
    {{-- <div id="loader"></div> --}}

    <!-- Mouse Cursor  -->
    <div class="mouseCursor cursor-outer"></div>
    <div class="mouseCursor cursor-inner"><span>Drag</span></div>

    <div id="header-1" class="header-area">
        <div id="header-sticky">
            <div class="navigation">
                <div class="container-fluid">
                    <div class="header-inner-box">

                        <!-- Logo navbar-brand-->
                        <div class="logo">
                            <a class="" href="{{ route('home') }} "><img
                                    src="{{ asset('assets/img/logo.png') }}?updated=1" width="80px" alt="Kirin Flooring"></a>
                        </div>

                        <!-- Main Menu  -->
                        <div class="main-menu d-none d-lg-block">
                            <ul>
                                <li @class(['active' => request()->routeIs('home')])>
                                    <a class="navlink" href="{{ route('home') }}">Home</a>
                                </li>
                                <li @class(['active' => request()->routeIs('about_us')])>
                                    <a class="navlink" href="{{ route('about_us') }}">About Us</a>
                                </li>
                                {{-- <li @class(['active' => request()->routeIs('services')])>
                                    <a class="navlink" href="{{ route('services') }}">Services</a>
                                </li> --}}
                                <li @class(['active' => request()->routeIs('products')])>
                                    <a class="navlink" href="{{ route('products') }}">Products</a>
                                </li>
                                <li @class(['active' => request()->routeIs('technical_data')])>
                                    <a class="navlink" href="{{ route('technical_data') }}">Resources</a>
                                </li>
                                <li @class(['active' => request()->routeIs('blog.*')])>
                                    <a class="navlink has-arrow" href="#">Media Center</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('press-release.index') }}">Press Releases</a></li>
                                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                                    </ul>
                                </li>
                                <li @class(['active' => request()->routeIs('contact_us')])>
                                    <a class="navlink" href="{{ route('contact_us') }}">Contact</a>
                                </li>
                            </ul>
                        </div>

                        <div class="header-right">
                            <div class="me-3">
                                <a class="nav-icon position-relative" href="{{ route('cart.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" fill="currentColor">
                                        <title>cart-outline</title>
                                        <path
                                            d="M17,18A2,2 0 0,1 19,20A2,2 0 0,1 17,22C15.89,22 15,21.1 15,20C15,18.89 15.89,18 17,18M1,2H4.27L5.21,4H20A1,1 0 0,1 21,5C21,5.17 20.95,5.34 20.88,5.5L17.3,11.97C16.96,12.58 16.3,13 15.55,13H8.1L7.2,14.63L7.17,14.75A0.25,0.25 0 0,0 7.42,15H19V17H7C5.89,17 5,16.1 5,15C5,14.65 5.09,14.32 5.24,14.04L6.6,11.59L3,4H1V2M7,18A2,2 0 0,1 9,20A2,2 0 0,1 7,22C5.89,22 5,21.1 5,20C5,18.89 5.89,18 7,18M16,11L18.78,6H6.14L8.5,11H16Z" />
                                    </svg>
                                    <span id="cart-count"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ session('cart') ? array_sum(array_map(fn($item) => $item['quantity'], session('cart'))) : 0 }}
                                    </span>
                                </a>
                            </div>
                            <!-- Search Button  -->
                            <div class="search-trigger">
                                <i class="fal fa-search"></i>
                            </div>
                            <div class="contact-number d-none">
                                <div class="icon"><i class="las la-phone-volume"></i></div>
                                <div class="title">
                                    <h4><a href="tel:+94777385059" style="color: inherit; font-size: inherit;">+94 77 738 5059</a></h4>
                                </div>
                            </div>
                            <!--  <div class="header-btn">
                                <div class="menu-trigger">
                                    <span class="lines"></span>
                                    <span class="lines"></span>
                                    <span class="lines"></span>
                                </div>
                            </div> -->
                        </div>

                        <!-- Mobile Menu -->
                        <div class="mobile-nav-bar d-lg-none">
                            <div class="mobile-nav-wrap">
                                <div id="hamburger">
                                    <i class="las la-bars"></i>
                                </div>
                                <!-- mobile menu - responsive menu  -->
                                <div class="mobile-nav">
                                    <button type="button" class="close-nav">
                                        <i class="las la-times-circle"></i>
                                    </button>
                                    <nav class="sidebar-nav">
                                        <ul class="metismenu" id="mobile-menu">
                                            <li @class(['active' => request()->routeIs('home')])>
                                                <a href="{{ route('home') }}">Home</a>
                                            </li>
                                            <li @class(['active' => request()->routeIs('about_us')])>
                                                <a href="{{ route('about_us') }}">About Us</a>
                                            </li>
                                            {{-- <li @class(['active' => request()->routeIs('services')])>
                                                <a href="{{ route('services') }}">Services</a>
                                            </li> --}}
                                            <li @class(['active' => request()->routeIs('products')])>
                                                <a href="{{ route('products') }}">Products</a>
                                            </li>
                                            <li @class(['active' => request()->routeIs('technical_data')])>
                                                <a href="{{ route('technical_data') }}">Resources</a>
                                            </li>
                                            <li @class(['active' => request()->routeIs('blog.*')])>
                                                <a href="{{ route('blog.index') }}">Blog</a>
                                            </li>
                                            <li @class(['active' => request()->routeIs('contact_us')])>
                                                <a href="{{ route('contact_us') }}">Contact</a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <div class="action-bar">
                                        <a href="mailto:kirinfloors@sais.lk"><i
                                                class="las la-envelope"></i>kirinfloors@sais.lk</a>
                                        <a href="tel:+94777385059"><i class="fal fa-phone"></i>+94 77 738 5059</a>
                                        <a href="{{ route('contact_us') }}" class="theme-btn">Contact Us</a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /Mobile -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    @include('layouts.partials.footer')

    <!-- Cookie Consent Banner -->
    <div id="cookieConsentBanner" class="cookie-consent-banner">
        <div class="cookie-consent-content">
            <div class="cookie-consent-text">
                <p>
                    <strong>We value your privacy.</strong> This website uses cookies to enhance your browsing experience, 
                    analyze site traffic, and personalize content. By clicking "Accept All", you consent to our use of cookies.
                    {{-- <a href="#" onclick="event.preventDefault();">Learn more</a> --}}
                </p>
            </div>
            <div class="cookie-consent-actions">
                <button class="cookie-btn cookie-btn-decline" onclick="declineCookies()">Decline</button>
                <button class="cookie-btn cookie-btn-accept" onclick="acceptCookies()">Accept All</button>
            </div>
        </div>
    </div>
    <!-- back to top start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- Jquery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- Wow JS -->
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <!-- Way Points JS -->
    <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
    <!-- Pure Counter JS -->
    <script src="{{ asset('assets/js/pure-counter.js') }}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <!-- Slick Slider JS -->
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <!-- Magnific Popup JS -->
    <script src="{{ asset('assets/js/magnific-popup.min.js') }}"></script>
    <!-- Isotope JS -->
    <script src="{{ asset('assets/js/isotope-3.0.6-min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <!-- Back To Top JS -->
    <script src="{{ asset('assets/js/backToTop.js') }}"></script>
    <!-- Metis Menu JS -->
    <script src="{{ asset('assets/js/metismenu.js') }}"></script>
    <!-- Progress Bar JS -->
    <script src="{{ asset('assets/js/jquery.barfiller.js') }}"></script>
    <!-- Appear JS -->
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <!-- Odometer JS -->
    <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
    <!-- Fancybox Select JS -->
    <script src="{{ asset('assets/js/jquery-fancybox.min.js') }}"></script>
    <!-- GSAP Animation JS -->
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('assets/js/SplitText.min.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    
    <!-- Cookie Consent Script -->
    <script>
        // Check if user has already made a choice
        function checkCookieConsent() {
            const consent = localStorage.getItem('cookieConsent');
            const banner = document.getElementById('cookieConsentBanner');
            
            if (!consent) {
                // Show banner after a short delay
                setTimeout(() => {
                    banner.classList.add('show');
                }, 1000);
            }
        }

        function acceptCookies() {
            localStorage.setItem('cookieConsent', 'accepted');
            hideCookieBanner();
            // Initialize tracking scripts here if needed
            console.log('Cookies accepted');
        }

        function declineCookies() {
            localStorage.setItem('cookieConsent', 'declined');
            hideCookieBanner();
            console.log('Cookies declined');
        }

        function hideCookieBanner() {
            const banner = document.getElementById('cookieConsentBanner');
            banner.classList.remove('show');
        }

        // Check consent status when page loads
        document.addEventListener('DOMContentLoaded', checkCookieConsent);
    </script>
    
    @yield('scripts')
</body>

</html>
