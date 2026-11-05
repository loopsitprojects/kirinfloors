@extends('layouts.public')

@section('title', $data['meta_title'] ?? 'Kirin Flooring | Premium SPC & Click-Lock Flooring')

@section('meta')
    <meta name="description"
        content="{{ $data['meta_description'] ?? 'Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.' }}">
    <meta name="keywords" content="{{ $data['meta_keywords'] ?? 'flooring, SPC, click-lock, installation, Kirin' }}">
    {{-- @if ($data['canonical_url'] ?? false)
<link rel="canonical" href="{{ $data['canonical_url'] }}">
@endif
<meta name="robots" content="{{ $data['robots'] ?? 'index,follow' }}"> --}}
    @foreach ($data['custom_meta_tags'] ?? [] as $tag)
        <meta {{ $tag['attribute'] }}="{{ $tag['key'] }}" content="{{ $tag['content'] }}">
    @endforeach
@endsection

@section('content')

    <!-- Off-canvas Area-->
    <div class="extra-info">
        <div class="close-icon menu-close">
            <button>
                <i class="las la-times"></i>
            </button>
        </div>
        {{-- <div class="logo-side">
            <div class="logo">
                <a href="index.html"><img src="assets/img/logo-white.png" alt=""></a>
            </div>
        </div> --}}
        {{-- <div class="side-info">
            <div class="contact-list mb-40">
                <p>{{ $data['off_canvas_text'] }}</p>
                <img src="assets/img/off-canvas.jpg" alt="">
                <div class="mt-30 mb-30">
                    <a href="contact.html" class="white-btn">Get In Touch</a>
                </div>
            </div>
            <div class="social-area-wrap">
                <a href="#"><i class="lab la-facebook-f"></i></a>
                <a href="#"><i class="lab la-instagram"></i></a>
                <a href="#"><i class="lab la-linkedin-in"></i></a>
                <a href="#"><i class="lab la-skype"></i></a>
            </div>
        </div> --}}
    </div>

    <div class="offcanvas-overlay"></div>

    <!-- Breadcrumb Area  -->
    <div class="breadcrumb-area" style="background-image: url({{ Storage::publicUrl($data['breadcrumb_image']) }});">
        <div class="overlay-5"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="breadcrumb-title">
                        <h1>{{ $data['breadcrumb_title'] }}</h1>
                    </div>
                    <div class="breadcrumb-icon">
                        <i class="las la-angle-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section  -->

    <div id="about-page" class="about-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-7 order-2 order-md-1">
                    <div class="about-content-wrap">
                        {!! $data['about_description'] !!}
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 order-1 order-md-2">
                    <div class="about-img-wrap">
                        <img src="{{ Storage::publicUrl($data['about_image']) }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Section
    <div class="timeline-section section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="timeline-wrapper">
                    @foreach ($data['timeline'] ?? [] as $index => $item)
                        <div class="timeline-item {{ $index % 2 == 0 ? 'obverse' : 'reverse' }}">
                            <div class="timeline-line-wrap">
                                <span class="timeline-line"></span>
                            </div>
                            <div class="timeline-inner">
                                <div class="time-line-point-wrap">
                                    <div class="time-line-point"></div>
                                </div>
                                @if ($index % 2 == 0)
                                    <div class="timeline-img-wrap">
                                        <img src="{{ Storage::publicUrl($item['image']) }}" alt="">
                                    </div>
                                    <div class="timeline-content-wrap">
                                        <span class="timeline-date">{{ $item['date'] }}</span>
                                        <h5 class="timeline-title">{{ $item['title'] }}</h5>
                                        <p class="timeline-text">{{ $item['text'] }}</p>
                                    </div>
                                @else
                                    <div class="timeline-content-wrap order-2 order-md-1">
                                        <span class="timeline-date">{{ $item['date'] }}</span>
                                        <h5 class="timeline-title">{{ $item['title'] }}</h5>
                                        <p class="timeline-text">{{ $item['text'] }}</p>
                                    </div>
                                    <div class="timeline-img-wrap order-1 order-md-2">
                                        <img src="{{ Storage::publicUrl($item['image']) }}" alt="">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> -->

    <!-- About More  -->
    <div class="about-more">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h4>{{ $data['about_more_heading'] }}</h4>
                </div>
            </div>
            <div class="row gy-4 mt-40">
                <div class="col-lg-6 col-md-6">
                    <div class="about-more-img obverse">
                        <img src="{{ Storage::publicUrl($data['about_more_image']) }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="about-content-wrap obverse">
                        {!! $data['about_more_content'] !!}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- History Section  -->
    @if(!empty($data['history_description']) && !empty($data['history_image']))
    <div id="about-page" class="about-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-7 order-2 order-md-1">
                    <div class="about-content-wrap">
                        {!! $data['history_description'] !!}
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 order-1 order-md-2">
                    <div class="about-img-wrap">
                        <img src="{{ Storage::publicUrl($data['history_image']) }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Counter Section -->
    <div class="counter-section section-padding py-0">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-counter-box highlights">
                        <p class="counter-number"><span class="purecounter" data-purecounter-duration="1"
                                data-purecounter-end="{{ $data['counter_since'] }}">{{ $data['counter_since'] }}</span>
                        </p>
                        <h6>Since</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-counter-box">
                        <p class="counter-number"><span class="purecounter" data-purecounter-duration="1"
                                data-purecounter-end="{{ $data['counter_offices'] }}">{{ $data['counter_offices'] }}</span>
                        </p>
                        <h6>Design Ranges</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-counter-box">
                        <p class="counter-number"><span class="purecounter" data-purecounter-duration="1"
                                data-purecounter-end="{{ $data['counter_projects'] }}">{{ $data['counter_projects'] }}</span>
                        </p>
                        <h6>Designs</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="single-counter-box">
                        <p class="counter-number"><span class="purecounter" data-purecounter-duration="1"
                                data-purecounter-end="{{ $data['counter_countries'] }}">{{ $data['counter_countries'] }}</span>+
                        </p>
                        <h6>Retailers in Country</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    {{-- <div class="gallery-section showcase section-padding pt-70">
        <div class="container">
            <div class="row">
                <div class="section-title">
                    <h3 class="visible-slowly-right">{{ $data['gallery_title'] }}</h3>
                    <p>{{ $data['gallery_description'] }}</p>
                </div>
            </div>
            <div class="row gy-4">
                @foreach ($data['gallery'] ?? [] as $index => $item)
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft animated"
                        data-wow-delay="{{ 200 + ($index % 3) * 200 }}ms">
                        <a href="{{ Storage::publicUrl($item['image']) }}" data-fancybox="gallery">
                            <img src="{{ Storage::publicUrl($item['image']) }}" alt="{{ $item['alt'] }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    <!-- Team Section -->
    <div class="team-section section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">
                            {{ $data['team_title'] }}</h2>
                    </div>
                    <p>{{ $data['team_description'] }}</p>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-5 text-md-end">
                    <a href="{{ route('about_us') }}" class="bordered-btn">Our Team <i class="fa-light fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="row mt-30">
                @foreach ($data['team_members'] ?? [] as $index => $member)
                    <div class="col-xl-3 col-lg-3 col-md-6 wow fadeInUp animated"
                        data-wow-delay="{{ 200 + $index * 200 }}ms">
                        <div class="single-team-item">
                            <div class="team-img">
                                <img src="{{ Storage::publicUrl($member['image']) }}"
                                    alt="">
                            </div>
                            <div class="team-info">
                                <span>{{ $member['position'] }}</span>
                                <h5>{{ $member['name'] }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
