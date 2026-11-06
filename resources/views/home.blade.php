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
    <!-- Hero Area -->
    <div id="home-1" class="homepage-slides owl-carousel">
        @foreach ($data['hero_slides'] as $slide)
            <div class="single-slide-item d-flex align-items-center"
                data-background="{{ Storage::publicUrl($slide['image']) }}">
                <div class="overlay-4"></div>
                <div class="hero-area-content">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-12 col-lg-12 col-md-10 wow fadeInUp animated" data-wow-delay=".2s">
                                <div class="section-title">
                                    <h6 class="text-white">{{ $slide['subtitle'] }}</h6>
                                    <h1 class="text-white">{!! Str::sanitizeHtml((string) ($slide['title'] ?? '')) !!}</h1>
                                </div>
                                <p class="text-white">{{ $slide['description'] }}</p>
                                <a href="{{ $slide['button_link'] }}" class="white-btn mt-40">{{ $slide['button_text'] }} <i
                                        class="fa-light fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Off-canvas Area-->
    <div class="extra-info">
        <div class="close-icon menu-close">
            <button>
                <i class="las la-times"></i>
            </button>
        </div>
        <div class="logo-side">
            <div class="logo">
                <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="Kirin Flooring"></a>
            </div>
        </div>
        <div class="side-info">
            <div class="contact-list mb-40">
                <p>Welcome to our flooring studio—specialists in SPC collections and precision click-lock systems for
                    rapid, reliable installs.</p>
                <img src="{{ asset('assets/img/off-canvas.jpg') }}" alt="Showcase">
                <div class="mt-30 mb-30">
                    <a href="{{ route('contact_us') }}" class="white-btn">Get In Touch</a>
                </div>
            </div>
            {{-- <div class="social-area-wrap">
                @if ($data['social_facebook'])
                    <a href="{{ $data['social_facebook'] }}" target="_blank" rel="noopener"><i
                            class="lab la-facebook-f"></i></a>
                @endif
                @if ($data['social_instagram'])
                    <a href="{{ $data['social_instagram'] }}" target="_blank" rel="noopener"><i
                            class="lab la-instagram"></i></a>
                @endif
                @if ($data['social_youtube'])
                    <a href="{{ $data['social_youtube'] }}" target="_blank" rel="noopener"><i
                            class="lab la-youtube"></i></a>
                @endif
                @if ($data['social_tiktok'])
                    <a href="{{ $data['social_tiktok'] }}" target="_blank" rel="noopener"><i
                            class="fa-brands fa-tiktok"></i></a>
                @endif
                @if ($data['social_linkedin'])
                    <a href="{{ $data['social_linkedin'] }}" target="_blank" rel="noopener"><i
                            class="lab la-linkedin-in"></i></a>
                @endif
            </div> --}}
        </div>
    </div>

    <div class="offcanvas-overlay"></div>

    <!-- Service Section -->

    <div id="project-1" class="project-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">{{ $data['services_title'] }}</h2>
                        <p class="pt-20 wow fadeInUp animated" data-wow-delay=".4s">{{ $data['services_description'] }}
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-5 text-md-end">
                    <a href="{{ route('products') }}" class="bordered-btn">View All Services <i
                            class="fa-light fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="row project-wrapper">
                <div class="project-slider owl-carousel">
                    @foreach ($data['products'] as $product)
                        <a href="{{ route('product.show', $product) }}">
                            <div class="single-project-item">
                                <div class="project-bg">
                                    <img src="{{ Storage::publicUrl($product['image']) }}" alt="">
                                </div>
                                <div class="project-info">
                                    <h6>{{ $product['name'] }}</h6>
                                    Read More
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- <div id="service-1" class="service-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">{{ $data['services_title'] }}</h2>
                        <p class="pt-20 wow fadeInUp animated" data-wow-delay=".4s">{{ $data['services_description'] }}</p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-5 text-md-end">
                    <a href="{{ route('services') }}" class="bordered-btn">View All Services <i
                            class="fa-light fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="row service-wrapper">
                @foreach ($data['services'] as $index => $service)
                    <div class="col-xl-3 col-lg-3 col-md-6 {{ $index % 2 == 1 ? 'mt-50' : '' }} wow fadeInLeft animated"
                        data-wow-delay="{{ 200 + $index * 200 }}ms">
                        <div class="single-service-item">
                            <img src="{{ Storage::publicUrl($service['image']) }}" alt="">
                            <div class="service-info-wrap">
                                <div class="service-info-inner">
                                    <span>{{ $service['label'] }}</span>
                                    <h5>{{ $service['title'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div><!-- /accordions -->
    </div> --}}

    <!-- About Section -->
    <div id="about-1" class="about-section section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">{{ $data['about_title'] }}</h2>
                        <p class="pt-20 wow fadeInUp animated" data-wow-delay=".4s">{{ $data['about_description'] }}
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-5 text-md-end">
                    <a href="{{ route('about_us') }}" class="bordered-btn">About Us <i
                            class="fa-light fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="row gx-0">
                <div class="col-xl-6 col-lg-6">
                    <div class="wow img-custom-anim-left h-100 py-md-0 py-3" data-wow-delay=".3s">
                        {{-- <img src="{{ Storage::publicUrl($data['about_image']) }}" alt=""> --}}
                        <iframe width="100%" height="100%"
                            src="https://www.youtube.com/embed/yFClovzaVpM?si=Q6dRgJ5kWqMNCoVv&amp;controls=0"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="cp-custom-accordion">
                        <div class="accordions" id="accordionAbout">
                            <div class="accordion-items">
                                <h2 class="accordion-header" id="aboutOne">
                                    <button class="accordion-buttons" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        History
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="aboutOne"
                                    data-bs-parent="#accordionAbout">
                                    <div class="accordion-body">
                                        {!! Str::sanitizeHtml((string) ($data['history_content'] ?? '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-items">
                                <h2 class="accordion-header" id="aboutTwo">
                                    <button class="accordion-buttons collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Mission
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="aboutTwo"
                                    data-bs-parent="#accordionAbout">
                                    <div class="accordion-body">
                                        {!! Str::sanitizeHtml((string) ($data['mission_content'] ?? '')) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-items">
                                <h2 class="accordion-header" id="aboutThree">
                                    <button class="accordion-buttons collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Vision
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="aboutThree"
                                    data-bs-parent="#accordionAbout">
                                    <div class="accordion-body">
                                        {!! Str::sanitizeHtml((string) ($data['vision_content'] ?? '')) !!}
                                    </div>
                                </div>
                            </div>

                        </div><!-- /accordions -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery Section -->
    {{-- <div class="gallery-section gray-bg section-padding pt-0">
        <div class="container">
            <div class="row gy-4">
                @foreach ($data['gallery'] as $index => $image)
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInLeft animated"
                        data-wow-delay="{{ 200 + $index * 200 }}ms">
                        <a href="{{ Storage::publicUrl($image['image']) }}" data-fancybox="gallery">
                            <img src="{{ Storage::publicUrl($image['image']) }}" alt="{{ $image['alt'] }}">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    <!-- Sponsors Section
    <div class="sponsors-section section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">{{ $data['sponsors_title'] }}</h2>
                        {{-- <p class="pt-20 wow fadeInUp animated" data-wow-delay=".4s">{{ $data['sponsors_description'] }}
                        </p> --}}
                    </div>
                </div>
                {{-- <div class="col-xl-7 col-lg-6 col-md-5 text-md-end">
                    <a href="projects.html" class="bordered-btn">View All Projects <i
                            class="fa-light fa-arrow-right"></i></a>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="sponsors-carousel owl-carousel">
                        @foreach ($data['sponsors'] as $sponsor)
                            <div class="single-sponsor">
                                <img src="{{ Storage::publicUrl($sponsor['logo']) }}" alt="{{ $sponsor['alt'] }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Project Section
    <div id="project-1" class="project-section section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">{{ $data['projects_title'] }}</h2>
                        <p class="pt-20 wow fadeInUp animated" data-wow-delay=".4s">{{ $data['projects_description'] }}
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-5 text-md-end">
                    <a href="{{ route('products') }}" class="bordered-btn">View All Projects <i
                            class="fa-light fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="row project-wrapper">
                <div class="project-slider owl-carousel">
                    @foreach ($data['projects'] as $project)
                        <div class="single-project-item">
                            <div class="project-bg">
                                <img src="{{ Storage::publicUrl($project['image']) }}" alt="">
                            </div>
                            <div class="project-info">
                                <h6>{{ $project['title'] }}</h6>
                                <a href="{{ $project['link'] }}">Read More</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> -->

    <!-- Process Section -->
    <div id="process-1" class="process-section section-padding pt-0 pb-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">{{ $data['process_title'] }}</h2>
                        <p class="pt-20 wow fadeInUp animated" data-wow-delay=".4s">{{ $data['process_description'] }}
                        </p>
                    </div>
                </div>
                {{-- <div class="col-xl-7 col-lg-6 col-md-5 text-md-end">
                    <a href="contact.html" class="bordered-btn">Our Process <i class="fa-light fa-arrow-right"></i></a>
                </div> --}}
            </div>
        </div>
        <div class="row mt-30 process-bg-wrap align-items-center justify-content-center"
            data-background="{{ Storage::publicUrl($data['process_background']) }}">
            @foreach ($data['process_steps'] as $index => $step)
                <div class="col-xl-3 col-lg-3 col-md-6 wow fadeInLeft animated"
                    data-wow-delay="{{ 200 + $index * 200 }}ms">
                    <div class="single-process-item">
                        <div class="process-icon">
                            <img src="{{ Storage::publicUrl($step['icon']) }}" alt="">
                            <span class="step-count">{{ $index + 1 }}.</span>
                            @if (!$loop->last)
                                <div class="process-line d-none d-md-inline-block"></div>
                            @endif
                        </div>
                        <div class="process-title">
                            <h5>{{ $step['title'] }}</h5>
                        </div>
                        <div class="process-content">
                            <p>{{ $step['description'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Testimonial Section
    <div class="testimonial-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">{{ $data['testimonials_title'] }}</h2>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6 col-md-5 text-md-end">
                    <a href="{{ route('services') }}" class="bordered-btn">Testimonials <i
                            class="fa-light fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="testimonial-one owl-carousel">
                    @foreach ($data['testimonials'] as $testimonial)
                        <div class="single-testimonial-item">
                            <div class="testimonial-quote">
                                <img src="{{ asset('assets/img/quote.png') }}" alt="">
                            </div>
                            <div class="testimonial-content">
                                <div class="testimonial-text">
                                    <p>{{ $testimonial['quote'] }}</p>
                                </div>
                                <div class="testimonial-author">
                                    <h5>{{ $testimonial['author_name'] }}</h5>
                                    <span>{{ $testimonial['author_position'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> -->

    <!-- Team Section -->
    <div class="team-section section-padding pb-90">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">{{ $data['team_title'] }}</h2>
                    </div>
                    <p class="wow fadeInUp animated" data-wow-delay=".4s">{{ $data['team_description'] }}</p>
                </div>
                {{-- <div class="col-xl-6 col-lg-6 col-md-5 text-md-end">
                    <a href="team.html" class="bordered-btn">Our Team <i class="fa-light fa-arrow-right"></i></a>
                </div> --}}
            </div>
            <div class="row mt-30">
                @foreach ($data['team_members'] as $index => $member)
                    <div class="col-xl-3 col-lg-3 col-md-6 wow fadeInUp animated"
                        data-wow-delay="{{ 200 + $index * 200 }}ms">
                        <div class="single-team-item">
                            <div class="team-img">
                                <img src="{{ Storage::publicUrl($member['image']) }}" alt="">
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

    <!-- Blog Section -->
    <div id="blog-1" class="blog-section section-padding pt-0 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">{{ $data['latest_news_title'] }}</h2>
                    </div>
                    <p class="wow fadeInUp animated" data-wow-delay=".4s">{{ $data['latest_news_description'] }}</p>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-5 text-md-end">
                    <a href="{{ route('blog.index') }}" class="bordered-btn">View Latest News <i
                            class="fa-light fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="row mt-60">
                @foreach ($data['latest_blogs'] as $index => $news)
                    <div class="col-lg-6 col-md-12 wow fadeInUp animated" data-wow-delay="{{ 200 + $index * 200 }}ms">
                        <div class="single-blog-item">
                            <div class="blog-title">
                                <h5><a
                                        href="{{ route('blog.show', $news->slug) }}">{{ $news['title'] }}</a>
                                </h5>
                            </div>
                            <div class="blog-content">
                                <p>{{ $news['short_description'] }}</p>
                            </div>
                            <a href="{{ route('blog.show', $news->slug) }}"
                                class="read-more-btn bordered-btn">Read More</a>
                            @if ($index < 2)
                                <hr>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
