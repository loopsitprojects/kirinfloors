@extends('layouts.public')

@section('title', 'Order Confirmed | Kirin Flooring')

@section('content')
    <!-- Breadcrumb Area  -->
    <div class="breadcrumb-area" style="background-color: #111111;">
        <div class="overlay-5"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="breadcrumb-title">
                        <h1>Order Confirmed</h1>
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
                            <i class="las la-shopping-bag" style="font-size: 100px; color: var(--brand-gold);"></i>
                        </div>
                        <h2 class="mb-3">Thank You for Your Order!</h2>
                        <p class="mb-5">Your order has been placed successfully. We will process it and contact you shortly with further details.</p>
                        <a href="{{ route('home') }}" class="theme-btn">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
