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

        /* Category Tabs */
        .category-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e5e7eb;
            flex-wrap: wrap;
        }

        .category-tab {
            padding: 1rem 2rem;
            background: transparent;
            border: none;
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--brand-gray);
            cursor: pointer;
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }

        .category-tab:hover {
            color: var(--brand-dark);
        }

        .category-tab.active {
            color: var(--brand-dark);
            border-bottom-color: var(--brand-gold);
        }

        .category-content {
            display: none;
        }

        .category-content.active {
            display: block;
            animation: fadeIn 0.4s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .category-description {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--brand-gold);
        }

        .dimension-inputs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
        }

        .dimension-input {
            width: 70px;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .calculated-price {
            font-size: 1.1rem;
            color: var(--brand-gold);
            font-weight: 600;
            margin-bottom: 0.5rem;
            min-height: 1.5rem;
        }

        .price-label {
            font-size: 0.875rem;
            color: var(--brand-gray);
            margin-bottom: 0.5rem;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb Area  -->
    <div class="breadcrumb-area" style="background-image: url({{ asset('assets/img/products/bc.png') }});">
        <div class="overlay-5"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="breadcrumb-title">
                        <h1>Our Products</h1>
                    </div>
                    <div class="breadcrumb-icon">
                        <i class="las la-angle-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Section -->
    <div id="project-1" class="project-section section-padding">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-6 col-lg-6 col-md-7">
                    <div class="section-title">
                        <h2 class="visible-slowly-right">Our Collection</h2>
                        <p class="pt-20">Discover the perfect foundation for your home with our premium SPC flooring.</p>
                    </div>
                </div>
            </div>

            @if ($productsByCategory->count() > 0)
                <!-- Category Tabs , 'ACCESSORIES'-->
                <div class="category-tabs" role="tablist">
                    @foreach (['TIMBERLINE', 'STONEDGE'] as $index => $category)
                        <button class="category-tab {{ $index === 0 ? 'active' : '' }}"
                            data-category="{{ Str::slug($category) }}" role="tab"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                            {{ ucwords(str_replace('_', ' ', $category)) }}
                        </button>
                    @endforeach
                </div>

                <!-- Category Content -->
                @foreach (['TIMBERLINE', 'STONEDGE', 'ACCESSORIES'] as $category)
                    <div class="category-content {{ $loop->first ? 'active' : '' }}"
                        id="category-{{ Str::slug($category) }}" role="tabpanel">

                        {{-- <div class="category-description">
                            <h4 class="text-brand-dark mb-2">{{ ucwords(str_replace('_', ' ', $category)) }} Collection</h4>
                            <p class="mb-0">
                                @if (strtoupper($category) === 'TIMBERLINE')
                                    Experience the warmth and natural beauty of wood with our Timberline collection. Perfect for creating elegant, timeless spaces.
                                @elseif(strtoupper($category) === 'STONEDGE')
                                    Discover the sophisticated appeal of stone with our StoneEdge collection. Ideal for modern, durable flooring solutions.
                                @else
                                    Browse our premium {{ $category }} collection for quality flooring solutions.
                                @endif
                            </p>
                        </div> --}}

                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4 project-wrapper">
                            @forelse ($productsByCategory[$category] ?? [] as $product)
                                <div class="col">
                                    <div class="card h-100 product-card">
                                        <a href="{{ route('product.show', $product) }}">
                                            <img src="{{ Storage::publicUrl($product->image) }}" class="card-img-top"
                                                alt="{{ $product->name }}">
                                        </a>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title flex-grow-1">
                                                <a href="{{ route('product.show', $product) }}">{{ $product->name }}</a>
                                            </h5>
                                            {{-- <div class="card-text mb-2">Rs. {{ number_format($product->price, 2) }} per linear ft</div> --}}
                                            {{-- <form action="{{ route('cart.store') }}" method="POST" class="product-form" data-product-id="{{ $product->id }}" data-price="{{ $product->price }}">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <div class="dimension-inputs">
                                                    <input type="number" name="height" class="form-control dimension-input height-input" placeholder="Height (ft)" min="0" step="0.01" required>
                                                    <span class="align-self-center">×</span>
                                                    <input type="number" name="width" class="form-control dimension-input width-input" placeholder="Width (ft)" min="0" step="0.01" required>
                                                </div>
                                                <div class="calculated-price" data-product-id="{{ $product->id }}"></div> --}}
                                            <div class="d-grid gap-2 d-sm-flex justify-content-between align-items-center">
                                                <a href="{{ route('product.show', $product) }}"
                                                    class="btn btn-brand-dark btn-sm add-to-cart-btn"
                                                    data-id="{{ $product->id }}">Add to
                                                    Cart</a>
                                                {{-- <button type="submit" class="btn btn-brand-dark btn-sm add-to-cart-btn w-full" data-id="{{ $product->id }}" disabled>Add to Cart</button> --}}
                                                <a href="{{ route('product.show', $product) }}"
                                                    class="btn btn-outline-secondary btn-sm">Read More</a>
                                            </div>
                                            {{-- </form> --}}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">No products available at the moment.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-info">No products available at the moment.</div>
            @endif
        </div>
    </div>

    {{-- <!-- Project Slider -->
    <div class="project-slider-wrap-two">
        <div class="project-img-slider-two owl-carousel">
            <div class="project-img">
                <img src="{{ asset('assets/img/products/project-slider/2-1.jpg') }}" alt="">
            </div>
            <div class="project-img">
                <img src="{{ asset('assets/img/products/project-slider/2-2.jpg') }}" alt="">
            </div>
            <div class="project-img">
                <img src="{{ asset('assets/img/products/project-slider/2-4.jpg') }}" alt="">
            </div>
        </div>
    </div>

    <!-- Process Section -->
    <div id="process-2" class="process-section section-padding">
        <div class="container">
            <div class="row gy-5">
                <div class="col-xl-5 col-lg-4 col-md-4">
                    <div class="section-title">
                        <h6>Our Process</h6>
                        <h2 class="visible-slowly-right">From consultation to perfection, every time</h2>
                        <p class="pt-20">Our seamless flooring process ensures quality from consultation to installation,
                            guaranteeing satisfaction every step of the way.</p>
                    </div>
                    <a href="testimonial.html" class="bordered-btn">Get In Touch <i class="fa-light fa-arrow-right"></i></a>
                </div>
                <div class="col-xl-1 col-lg-1 col-md-1"></div>
                <div class="col-xl-6 col-lg-7 col-md-7">
                    <div class="single-process-wrap wow fadeInUp animated" data-wow-delay="200ms">
                        <div class="process-icon">
                            <img src="{{ asset('assets/img/products/process/2-1.png') }}" alt="">
                            <span class="step-count">1.</span>
                        </div>
                        <div class="process-content">
                            <div class="process-title">
                                <h5>Consultation</h5>
                            </div>
                            <div class="process-text">
                                <p>The architecture company meets with the client to discuss their needs, budget, and
                                    timeline.</p>
                            </div>
                        </div>
                    </div>
                    <div class="single-process-wrap wow fadeInUp animated" data-wow-delay="400ms">
                        <div class="process-icon">
                            <img src="{{ asset('assets/img/products/process/2-2.png') }}" alt="">
                            <span class="step-count">2.</span>
                        </div>
                        <div class="process-content">
                            <div class="process-title">
                                <h5>Material Selection</h5>
                            </div>
                            <div class="process-text">
                                <p>The architecture company meets with the client to discuss their needs, budget, and
                                    timeline.</p>
                            </div>
                        </div>
                    </div>
                    <div class="single-process-wrap wow fadeInUp animated" data-wow-delay="600ms mb-0">
                        <div class="process-icon">
                            <span class="step-count">3.</span>
                            <img src="{{ asset('assets/img/products/process/2-3.png') }}" alt="">
                        </div>
                        <div class="process-content">
                            <div class="process-title">
                                <h5>Preparation</h5>
                            </div>
                            <div class="process-text">
                                <p>The architecture company meets with the client to discuss their needs, budget, and
                                    timeline.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.category-tab');
            const contents = document.querySelectorAll('.category-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');

                    // Remove active class from all tabs and contents
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    contents.forEach(c => c.classList.remove('active'));

                    // Add active class to clicked tab and corresponding content
                    this.classList.add('active');
                    this.setAttribute('aria-selected', 'true');
                    document.getElementById('category-' + category).classList.add('active');

                    // Smooth scroll to content
                    document.getElementById('category-' + category).scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                });
            });

            // Handle dimension inputs and calculate price
            const forms = document.querySelectorAll('.product-form');

            forms.forEach(form => {
                const heightInput = form.querySelector('.height-input');
                const widthInput = form.querySelector('.width-input');
                const priceDisplay = form.querySelector('.calculated-price');
                const addToCartBtn = form.querySelector('.add-to-cart-btn');
                const pricePerLinearFoot = parseFloat(form.dataset.price);

                function calculateAndDisplay() {
                    const height = parseFloat(heightInput.value) || 0;
                    const width = parseFloat(widthInput.value) || 0;

                    if (height > 0 && width > 0) {
                        // Calculate linear feet (perimeter: 2 * (height + width))
                        const linearFeet = (height * width);
                        const totalPrice = linearFeet * pricePerLinearFoot;

                        priceDisplay.textContent =
                            `${linearFeet.toFixed(2)} linear ft = Rs. ${totalPrice.toFixed(2)}`;
                        addToCartBtn.disabled = false;
                    } else {
                        priceDisplay.textContent = '';
                        addToCartBtn.disabled = true;
                    }
                }

                heightInput.addEventListener('input', calculateAndDisplay);
                widthInput.addEventListener('input', calculateAndDisplay);
            });
        });
    </script>
@endsection
