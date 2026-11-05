@extends('layouts.public')

@section('title', $data['meta_title'] ?? 'Kirin Flooring | Premium SPC & Click-Lock Flooring')

@section('meta')
    <meta name="description"
        content="{{ $data['meta_description'] ?? 'Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.' }}">
    <meta name="keywords" content="{{ $data['meta_keywords'] ?? 'flooring, SPC, click-lock, installation, Kirin' }}">
    @foreach ($data['custom_meta_tags'] ?? [] as $tag)
        <meta {{ $tag['attribute'] }}="{{ $tag['key'] }}" content="{{ $tag['content'] }}">
    @endforeach
@endsection

@section('content')
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

    <!-- Service Section -->
    <div id="service-3" class="service-page service-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">{{ $data['service_title'] }}</h2>
                        <p class="pt-20">{{ $data['service_description'] }}</p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-5 text-md-end">
                    <a href="{{ route('products') }}" class="bordered-btn">View All Services <i
                            class="fa-light fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="row gy-4 align-items-center">
                <div class="col-lg-6">
                    <div class="service-img-wrap wow img-custom-anim-left" data-wow-delay=".3s">
                        <img src="{{ Storage::publicUrl($data['service_main_image']) }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row gy-4">
                        @php
                            $delays = ['200ms', '400ms', '600ms', '800ms'];
                            $classes = ['', 'pt-60', 'pt-m-60', ''];
                        @endphp
                        @foreach ($data['services'] ?? [] as $index => $service)
                            <div class="col-md-6 col-sm-6 wow fadeInUp animated {{ $classes[$index] ?? '' }}"
                                data-wow-delay="{{ $delays[$index] ?? '200ms' }}">
                                <div class="single-service-item">
                                    <img src="{{ Storage::publicUrl($service['image']) }}" alt="">
                                    <div class="service-info">
                                        <span>{{ $service['category'] }}</span>
                                        <h6>{{ $service['title'] }}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row mt-120">
                <div class="col-lg-6">
                    <div class="cp-custom-accordion">
                        <div class="accordions" id="accordionExample">
                            @foreach ($data['accordion_items'] ?? [] as $index => $item)
                                <div class="accordion-items">
                                    <h2 class="accordion-header" id="heading{{ $index + 1 }}">
                                        <button class="accordion-buttons{{ $index > 0 ? ' collapsed' : '' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#service{{ $index + 1 }}"
                                            aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                            aria-controls="service{{ $index + 1 }}">
                                            {{ $item['title'] }}
                                        </button>
                                    </h2>
                                    <div id="service{{ $index + 1 }}"
                                        class="accordion-collapse{{ $index == 0 ? ' collapse show' : ' collapse' }}"
                                        aria-labelledby="heading{{ $index + 1 }}"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {{ $item['content'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="service-img-wrap wow img-custom-anim-right" data-wow-delay=".3s">
                        <img src="{{ Storage::publicUrl($data['service_side_image']) }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial Section -->
    <div id="testimonial-2" class="testimonial-section section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="section-title">
                        <h6>testimonials</h6>
                        <h2 class="visible-slowly-right">
                            {{ $data['testimonials_title'] }}</h2>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2"></div>
                <div class="col-xl-4 col-lg-4 col-md-4">
                    <p class="pt-40">
                        {{ $data['testimonials_description'] }}
                    </p>
                    <a href="{{ route('contact_us') }}" class="details-link">Get in Touch<i class="fa-light fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="row mt-60">
                <div class="testimonial-two owl-carousel">
                    @foreach ($data['testimonials'] ?? [] as $index => $testimonial)
                        <div class="single-testimonial-wrap">
                            <div class="quote-wrap">
                                <img src="{{ asset('assets/img/quote-gray.png') }}" alt="">
                            </div>
                            <div class="testimonial-text">
                                <p>{{ $testimonial['quote'] }}</p>
                            </div>
                            <div class="testimonial-author">
                                <div class="author-img">
                                    <img src="{{ Storage::publicUrl($testimonial['author_image']) }}"
                                        alt="">
                                </div>
                                <div class="author-title">
                                    <h6>{{ $testimonial['author_name'] }}</h6>
                                    <p>{{ $testimonial['author_position'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
