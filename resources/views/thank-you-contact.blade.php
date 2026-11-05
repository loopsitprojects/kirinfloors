@extends('layouts.public')

@section('title', 'Thank You | Kirin Flooring')

@section('content')
    <!-- Breadcrumb Area  -->
    <div class="breadcrumb-area" style="background-color: #111111;">
        <div class="overlay-5"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="breadcrumb-title">
                        <h1>Thank You</h1>
                    </div>
                    <div class="breadcrumb-icon">
                        <i class="las la-angle-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="thank-you-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="thank-you-content">
                        <div class="icon mb-4">
                            <i class="las la-check-circle" style="font-size: 100px; color: var(--brand-gold);"></i>
                        </div>
                        <h2 class="mb-3">Message Sent Successfully!</h2>
                        <p class="mb-5">Thank you for contacting us. We have received your message and will get back to you as soon as possible.</p>
                        <a href="{{ route('home') }}" class="theme-btn">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
