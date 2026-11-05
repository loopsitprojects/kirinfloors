@extends('layouts.public')

@section('title', $data['meta_title'] ?? 'Kirin Flooring | Premium SPC & Click-Lock Flooring')

{{-- @section('meta')
    <meta name="description"
        content="{{ $data['meta_description'] ?? 'Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.' }}">
    <meta name="keywords" content="{{ $data['meta_keywords'] ?? 'flooring, SPC, click-lock, installation, Kirin' }}">
    @foreach ($data['custom_meta_tags'] ?? [] as $tag)
        <meta {{ $tag['attribute'] }}="{{ $tag['key'] }}" content="{{ $tag['content'] }}">
    @endforeach
@endsection --}}
@section('styles')
    <style>
        /* Buttons */
        .btn-brand-dark {
            background-color: var(--brand-dark);
            color: white;
            border-radius: 0.375rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-brand-dark:hover {
            background-color: var(--brand-gold);
            color: var(--brand-dark);
        }

        .btn-brand-gold {
            background-color: var(--brand-gold);
            color: var(--brand-dark);
            font-weight: 500;
        }

        .btn-brand-gold:hover {
            background-color: #c9a351;
            color: var(--brand-dark);
        }

        .btn-outline-secondary {
            border-radius: 0.375rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
        }

        /* Product Card */
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .product-card .card-title a {
            text-decoration: none;
            font-size: 1.5rem;
            color: var(--brand-dark);
            transition: color 0.3s ease;
        }

        .product-card .card-title a:hover {
            color: var(--brand-gold);
        }

        .product-card .card-img-top {
            aspect-ratio: 1 / 1;
            object-fit: cover;
        }

        .product-card .card-text {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--brand-gray);
        }

        /* Text & Colors */
        .text-brand-gold {
            color: var(--brand-gold);
        }

        .text-brand-dark {
            color: var(--brand-dark);
        }

        .bg-brand-dark {
            background-color: var(--brand-dark);
        }

        .bg-brand-gold {
            background-color: var(--brand-gold);
        }

        .tracking-wider {
            letter-spacing: 0.05em;
        }

        /* Product Detail Page */
        .product-detail-carousel .carousel-item img {
            max-height: 550px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .quantity-input {
            width: 4rem;
            text-align: center;
        }

        .nav-tabs .nav-link {
            color: var(--brand-gray);
        }

        .nav-tabs .nav-link.active {
            color: var(--brand-gold);
            border-color: #dee2e6 #dee2e6 var(--brand-gold);
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb Area  -->
    <div class="breadcrumb-area" style="background-image: url({{ asset('assets/img/cart-bg.png') }});">
        <div class="overlay-5"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="breadcrumb-title">
                        <h1>Request a Quote</h1>
                    </div>
                    <div class="breadcrumb-icon">
                        <i class="las la-angle-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <main class="py-5">
        <div class="container">
            <div class="row g-4">
                @if (empty($cart))
                    <div class="text-center p-5 bg-white rounded shadow">
                        <p class="h4 text-muted">Your cart is empty. Add a product to request a quote.</p>
                        <a href="{{ route('products') }}" class="btn btn-brand-gold mt-4">Continue Shopping</a>
                    </div>
                @else
                    <form action="{{ route('checkout.store') }}" method="POST" data-recaptcha="quote">
                        @csrf
                        <div class="row g-5">
                            <div class="col-lg-7">
                                <div class="bg-white p-4 p-md-5 rounded shadow-sm">
                                    <h3 class="mb-2">Request a Quote</h3>
                                    <p class="text-muted mb-4">Tell us about your space and our team will call you with a quote.</p>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                                placeholder="Name *" autocomplete="name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}"
                                                placeholder="Contact number *" autocomplete="tel" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="tel" class="form-control" name="whatsapp" value="{{ old('whatsapp') }}"
                                                placeholder="WhatsApp number (optional)">
                                        </div>
                                        <div class="col-12">
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                                placeholder="Email address *" autocomplete="email" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="city" value="{{ old('city') }}"
                                                placeholder="City *" required>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-select" name="property_type" required>
                                                <option value="" disabled @selected(!old('property_type'))>Property type *</option>
                                                <option value="House" @selected(old('property_type') === 'House')>House</option>
                                                <option value="Commercial property" @selected(old('property_type') === 'Commercial property')>Commercial property</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="bg-white p-4 p-md-5 rounded shadow-sm mt-4">
                                <h3 class="mb-4">Payment Details</h3>
                                <form class="row g-3">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="card_number" placeholder="Card Number">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="card_name" placeholder="Name on Card">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="card_expiration" placeholder="Expiration (MM/YY)">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="card_cvc" placeholder="CVC">
                                    </div>
                                </form>
                            </div> --}}
                            </div>
                            <div class="col-lg-5">
                                {{-- sticky-top --}}
                                <div class="bg-white p-4 rounded shadow-sm " style="top: 100px;">
                                    <h3 class="mb-4">Your Selection</h3>
                                    <div class="d-flex flex-column gap-3 mb-3">
                                        @foreach ($products as $product)
                                            @php
                                                $cartItem = is_array($cart[$product->id]) ? $cart[$product->id] : ['quantity' => $cart[$product->id], 'height' => 0, 'width' => 0];
                                                $floorArea = \App\Http\Controllers\CartController::floorArea($cartItem);
                                                $height = $cartItem['height'] ?? 0;
                                                $width = $cartItem['width'] ?? 0;
                                            @endphp
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ Storage::publicUrl($product->image) }}"
                                                        alt="{{ $product->name }}" class="rounded me-3"
                                                        style="width: 60px;">
                                                    <div>
                                                        <p class="fw-semibold text-black mb-0">{{ $product->name }}
                                                        </p>
                                                        <p class="text-muted small mb-0">{{ $height }} ft × {{ $width }} ft</p>
                                                        <p class="text-muted small mb-0">Floor area: {{ number_format($floorArea, 2) }} sq ft</p>
                                                    </div>
                                                </div>
                                                <p class="fw-semibold text-muted mb-0">On quote</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="border-top pt-3">
                                        <div class="d-flex justify-content-between pt-2 h5 fw-bold">
                                            <span>Price</span><span>On quote</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-brand-dark w-100 mt-4 btn-lg" type="submit">Request a Quote</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    @include('partials.recaptcha')
                @endif
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // main.js hides every select behind niceSelect, and browsers cannot
            // enforce `required` on a hidden select, so keep this one native.
            $('select[name="property_type"]').niceSelect('destroy');

            // Handle quantity change
            $('.quantity-input').on('change', function() {
                const productId = $(this).data('id');
                const newQuantity = parseInt($(this).val());
                updateCart(productId, newQuantity);
            });

            // Handle plus button
            $('.quantity-plus').on('click', function() {
                const productId = $(this).data('id');
                const currentQuantity = parseInt($(`.quantity-input[data-id="${productId}"]`).val());
                updateCart(productId, currentQuantity + 1);
            });

            // Handle minus button
            $('.quantity-minus').on('click', function() {
                const productId = $(this).data('id');
                const currentQuantity = parseInt($(`.quantity-input[data-id="${productId}"]`).val());
                if (currentQuantity > 1) {
                    updateCart(productId, currentQuantity - 1);
                }
            });

            // Handle remove from cart
            $('.remove-from-cart-btn').on('click', function() {
                const productId = $(this).data('id');
                updateCart(productId, 0);
            });

            // Function to update cart via AJAX
            function updateCart(productId, quantity) {}
            //     $.ajax({
            //         url: '/' + productId,
            //         method: 'PUT',
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             quantity: quantity
            //         },
            //         success: function(response) {
            //             location.reload();
            //         },
            //         error: function(xhr) {
            //             alert('Error updating cart. Please try again.');
            //         }
            //     });
            // }
        });
    </script>
@endsection
