@extends('layouts.public')

@section('title', 'Page Not Found | Kirin Flooring')

@section('meta')
    <meta name="robots" content="noindex">
@endsection

@section('content')
    <!-- Breadcrumb Area  -->
    <div class="breadcrumb-area" style="background-color: #111111;">
        <div class="overlay-5"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="breadcrumb-title">
                        <h1>Page Not Found</h1>
                    </div>
                    <div class="breadcrumb-icon">
                        <i class="las la-angle-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="not-found-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <p class="mb-2" style="font-size: 110px; line-height: 1; font-weight: 700; color: var(--brand-gold);">404</p>
                    <h2 class="mb-3">We couldn't find that page</h2>
                    <p class="mb-5">The link may be old, or the page may have moved. Try one of these instead.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="{{ route('home') }}" class="theme-btn">Back to Home</a>
                        <a href="{{ route('products') }}" class="theme-btn">View Products</a>
                        <a href="{{ route('contact_us') }}" class="theme-btn">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
