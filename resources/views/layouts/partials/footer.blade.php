    <!-- Floating Social Media Widget -->
    <div class="floating-social-widget">
        {{-- <a href="https://facebook.com/yourpage" target="_blank" class="social-icon-float facebook" title="Facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://instagram.com/yourpage" target="_blank" class="social-icon-float instagram"
            title="Instagram">
            <i class="fab fa-instagram"></i>
        </a> --}}
        <a href="https://wa.me/{{ Str::of($footerData['footer_phone'])->replace('+', '')->replace(' ', '') }}" target="_blank" rel="noopener" class="social-icon-float whatsapp" title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        {{-- <a href="https://linkedin.com/company/yourpage" target="_blank" class="social-icon-float linkedin"
            title="LinkedIn">
            <i class="fab fa-linkedin-in"></i>
        </a> --}}
    </div>
    <!-- Footer Section -->
    <div class="footer-section pt-80" data-background="{{ asset('assets/img/footer-bg.jpg') }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-5 col-md-6">
                    <div class="footer-content-wrap">
                        <div class="section-title">
                            <span class="text-white visible-slowly-right h2">{{ $footerData['footer_title'] }}</span>
                        </div>
                        <hr>
                        <p class="text-white wow fadeInUp animated" data-wow-delay="400ms">
                            {{ $footerData['footer_description'] }}
                        </p>
                        <a href="{{ route('contact_us') }}" class="white-btn mt-20 wow fadeInDown animated"
                            data-wow-delay="600ms">Let's
                            Talk <i class="fa-light fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-1"></div>
                <div class="col-xl-3 col-lg-3 col-md-5">
                    <div class="contact-info-wrap mt-40">
                        <div class="single-contact-info wow fadeInUp animated" data-wow-delay="200ms">
                            <h6 class="text-white">Phone</h6>
                            <p class="p-xl"><a href="tel:{{ preg_replace('/[^\d+]/', '', $footerData['footer_phone']) }}" style="color: inherit; font-size: inherit;">{{ $footerData['footer_phone'] }}</a></p>
                        </div>
                        <div class="single-contact-info wow fadeInUp animated" data-wow-delay="400ms">
                            <h6 class="text-white">E-mail</h6>
                            <p><a href="mailto:{{ $footerData['footer_email'] }}" style="color: inherit; font-size: inherit;">{{ $footerData['footer_email'] }}</a></p>
                        </div>
                        <div class="single-contact-info wow fadeInUp animated" data-wow-delay="600ms">
                            <h6 class="text-white">Address</h6>
                            <p>{!! nl2br($footerData['footer_address']) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="row align-items-center justify-content-center">
            <div class="site-info text-center">
                <p class="mb-0">© {{ date('Y') }} Kirin Floors. – All rights reserved.</p>
            </div>
        </div>
    </div>


    <!-- Search Dropdown -->
    <div class="search-popup">
        <span class="search-back-drop"></span>

        <div class="search-inner">
            <div class="container">
                <div class="logo">
                    <a class="navbar-brand" href="{{ route('home') }}"><img src="assets/img/logo-white.png" alt=""></a>
                </div>
                <button class="close-search"><span class="la la-times"></span></button>
                <form method="get" action="{{ route('products') }}">
                    <div class="form-group">
                        <input type="search" name="search-field" value="" placeholder="Type your keyword"
                            required="">
                        <button type="submit"><i class="fal fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
