@extends('layouts.public')

@section('title', $product->name . ' | Kirin Flooring | Premium SPC & Click-Lock Flooring')

@section('meta')
    <meta name="description"
        content="{{ $data['meta_description'] ?? 'Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.' }}">
    <meta name="keywords" content="{{ $data['meta_keywords'] ?? 'flooring, SPC, click-lock, installation, Kirin' }}">
    @foreach ($data['custom_meta_tags'] ?? [] as $tag)
        <meta {{ $tag['attribute'] }}="{{ $tag['key'] }}" content="{{ $tag['content'] }}">
    @endforeach
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

        .dimension-input-group {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .dimension-input-group input {
            width: 120px;
        }

        .calculated-price-display {
            font-size: 1.5rem;
            color: var(--brand-gold);
            font-weight: 600;
            margin: 1rem 0;
            min-height: 2rem;
        }

        .price-per-unit {
            font-size: 1.1rem;
            color: var(--brand-gray);
            margin-bottom: 1rem;
        }

        .nav-tabs .nav-link {
            color: var(--brand-gray);
        }

        .nav-tabs .nav-link.active {
            color: var(--brand-gold);
            border-color: #dee2e6 #dee2e6 var(--brand-gold);
        }

        .disclaimer {
            background-color: #f8f9fa;
            border-left: 4px solid var(--brand-gold);
            padding: 1rem;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <main class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div id="productCarousel" class="carousel slide product-detail-carousel shadow-lg"
                        data-bs-ride="carousel">
                        @if ($product->additional_images && count($product->additional_images) > 0)
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active"
                                    aria-current="true" aria-label="Slide 1"></button>
                                @foreach ($product->additional_images as $image)
                                    <button type="button" data-bs-target="#productCarousel"
                                        data-bs-slide-to="{{ $loop->index + 1 }}"
                                        aria-label="Slide {{ $loop->index + 2 }}"></button>
                                @endforeach
                            </div>
                        @endif
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ Storage::publicUrl($product->image) }}" class="d-block w-100"
                                    alt="{{ $product->name }} view 1">
                            </div>
                            @if ($product->additional_images && count($product->additional_images) > 0)
                                @foreach ($product->additional_images as $image)
                                    <div class="carousel-item">
                                        <img src="{{ Storage::publicUrl($image['path']) }}" class="d-block w-100"
                                            alt="{{ $product->name }} view {{ $loop->index + 2 }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @if ($product->additional_images && count($product->additional_images) > 0)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
                    <p class="text-muted">{{ $product->category }}</p>
                    <!--<p class="price-per-unit">Rs. {{ number_format($product->price, 2) }} per linear ft</p>-->
                    <p class="lead">{{ !empty($product->short_description) ? $product->short_description : $product->description }}</p>
                    <form action="{{ route('cart.store') }}" method="POST" class="mt-4" id="product-detail-form" data-price="{{ $product->price }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        
                        <div class="dimension-input-group">
                            <div>
                                <label for="height" class="form-label fw-bold">Length (ft):</label>
                                <input type="number" id="height" name="height" class="form-control" placeholder="Enter length" min="0" step="0.01" required>
                            </div>
                            <span class="fw-bold">×</span>
                            <div>
                                <label for="width" class="form-label fw-bold">Width (ft):</label>
                                <input type="number" id="width" name="width" class="form-control" placeholder="Enter width" min="0" step="0.01" required>
                            </div>
                        </div>
                        
                        <div class="calculated-price-display" id="calculated-price"></div>
                        
                        <button type="submit" class="btn btn-brand-dark btn-lg w-100 add-to-cart-btn" data-id="{{ $product->id }}" id="add-to-cart-btn" disabled>Add to Cart</button>
                    </form>
                </div>
                <div class="col-12">
                    @if ($product->category != 'ACCESSORIES')
                    <img src="{{ asset('assets/img/spc_value.png') }}" alt="Values of SPC flooring" class="img-fluid mx-auto d-block"
                        style="max-height: 400px; object-fit: cover;">
                    @endif
                </div>
            </div>

            <div class="mt-5 pt-4">
                <ul class="nav nav-tabs" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button" role="tab" aria-controls="description"
                            aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button"
                            role="tab" aria-controls="specs" aria-selected="false">Specifications</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="how-to-install-tab" data-bs-toggle="tab"
                            data-bs-target="#how-to-install" type="button" role="tab"
                            aria-controls="how-to-install" aria-selected="false">How to Install</button>
                    </li>
                </ul>
                <div class="tab-content bg-white p-4 border border-top-0" id="productTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                        aria-labelledby="description-tab">
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="tab-pane fade" id="specs" role="tabpanel" aria-labelledby="specs-tab">
                        <ul class="list-unstyled">
                            <li><strong>Design Code:</strong> {{ $product->design_code }}</li>
                            <li><strong>Design Grain:</strong> {{ $product->design_grain }}</li>
                            <li><strong>Colour Tone:</strong> {{ $product->colour_tone }}</li>
                            <li><strong>Texture:</strong> {{ $product->texture }}</li>
                            <li><strong>Application:</strong> {{ $product->application }}</li>
                            <li><strong>Dimensions:</strong> {{ $product->dimensions }}</li>
                        </ul>
                        <div class="disclaimer">
                            <p><strong>Disclaimer</strong></p>
                            <p>We do our best to show our flooring colours as accurately as possible. However, colours may look slightly different on screen due to lighting, screen settings, and how each device displays images.</p>
                            <p>Images are for reference only and may not reflect the exact colour of the product.</p>
                            <p>If you need an exact colour match, please contact us and we'll be happy to help with samples or further details.</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="how-to-install" role="tabpanel" aria-labelledby="how-to-install-tab">
                        <iframe width="100%" height="400px"
                            src="https://www.youtube.com/embed/yFClovzaVpM?si=Q6dRgJ5kWqMNCoVv&amp;controls=0"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('product-detail-form');
            const heightInput = document.getElementById('height');
            const widthInput = document.getElementById('width');
            const priceDisplay = document.getElementById('calculated-price');
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            const pricePerLinearFoot = parseFloat(form.dataset.price);

            function calculateAndDisplay() {
                const height = parseFloat(heightInput.value) || 0;
                const width = parseFloat(widthInput.value) || 0;

                if (height > 0 && width > 0) {
                    // Calculate linear feet (perimeter: 2 * (height + width))
                    const linearFeet = (height * width);
                    const totalPrice = linearFeet * pricePerLinearFoot;

                    priceDisplay.innerHTML = `<strong>${linearFeet.toFixed(2)} linear ft</strong>` // = Rs. ${totalPrice.toFixed(2)}`;
                    addToCartBtn.disabled = false;
                } else {
                    priceDisplay.textContent = '';
                    addToCartBtn.disabled = true;
                }
            }

            heightInput.addEventListener('input', calculateAndDisplay);
            widthInput.addEventListener('input', calculateAndDisplay);
        });
    </script>
@endsection
