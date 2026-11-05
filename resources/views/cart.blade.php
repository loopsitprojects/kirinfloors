@extends('layouts.public')

@section('title', $data['meta_title'] ?? 'Kirin Flooring | Premium SPC & Click-Lock Flooring')

@section('meta')
    <meta name="description"
        content="Products Cart. Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.">
    {{-- <meta name="keywords" content="{{ $data['meta_keywords'] ?? 'flooring, SPC, click-lock, installation, Kirin' }}"> --}}
    {{-- @foreach ($data['custom_meta_tags'] ?? [] as $tag)
        <meta {{ $tag['attribute'] }}="{{ $tag['key'] }}" content="{{ $tag['content'] }}">
    @endforeach --}}
@endsection
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
                        <h1>Cart</h1>
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
                        <p class="h4 text-muted">Your cart is empty.</p>
                        <a href="{{ route('products') }}" class="btn btn-brand-gold mt-4">Continue Shopping</a>
                    </div>
                @else
                    <div class="col-lg-8">
                        <div class="bg-white p-3 rounded shadow">
                            @foreach ($products as $product)
                                @php
                                    $cartItem = is_array($cart[$product->id]) ? $cart[$product->id] : ['quantity' => $cart[$product->id], 'linear_feet' => 0, 'height' => 0, 'width' => 0];
                                    $linearFeet = $cartItem['linear_feet'] ?? 0;
                                    $height = $cartItem['height'] ?? 0;
                                    $width = $cartItem['width'] ?? 0;
                                    $itemTotal = 0; //$product->price * $linearFeet;
                                @endphp
                                <div class="d-flex align-items-center py-3 border-bottom cart-item-row" data-id="{{ $product->id }}">
                                    <img src="{{ Storage::publicUrl($product->image) }}" alt="{{ $product->name }}"
                                        style="width: 100px; height: 100px; object-fit: cover;" class="rounded">
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mb-1">{{ $product->name }}</h5>
                                        {{-- <p class="text-muted mb-1">Rs. {{ 0 * number_format($product->price, 2) }} per linear ft</p> --}}
                                        <p class="text-muted mb-1 small">Dimensions: {{ $height }} ft × {{ $width }} ft</p>
                                        <p class="text-muted mb-1 small">Linear Feet: {{ number_format($linearFeet, 2) }}</p>
                                        <button class="btn btn-sm btn-outline-danger remove-from-cart-btn"
                                            data-id="{{ $product->id }}">Remove</button>
                                    </div>
                                    <div class="text-end fw-bold h5" style="width: 150px;">
                                        Rs. {{ number_format($itemTotal, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-4">
                        {{-- sticky-top --}}
                        <div class="bg-white p-4 rounded shadow" style="top: 100px;">
                            <h3 class="mb-4">Order Summary</h3>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span>Subtotal</span>
                                <span>Rs. {{ number_format($total ?? 0, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span>Shipping</span>
                                <span>Rs. {{ number_format(0, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-3 h5 fw-bold">
                                <span>Total</span>
                                <span>Rs. {{ number_format($total ?? 0, 2) }}</span>
                            </div>
                            <a href="{{ route('checkout.index') }}" id="checkout-button" class="btn btn-brand-dark w-100 mt-3">Proceed to
                                Checkout</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle remove from cart
            $('.remove-from-cart-btn').on('click', function() {
                const productId = $(this).data('id');
                
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    // disable all buttons
                    $('.remove-from-cart-btn').prop('disabled', true);
                    $('#checkout-button').prop('disabled', true);

                    $.ajax({
                        url: "{{ route('cart.store') }}",
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: productId,
                            quantity: 0
                        },
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Error removing item from cart. Please try again.');
                            $('.remove-from-cart-btn').prop('disabled', false);
                            $('#checkout-button').prop('disabled', false);
                        }
                    });
                }
            });
        });
    </script>
@endsection
