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
    .faq-section .card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .faq-section .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
    
    .faq-section .card .badge {
        transition: all 0.3s ease;
    }
    
    .faq-section .card:hover .badge {
        background-color: #D8B463 !important;
    }
</style>
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

    <!-- FAQ Section  -->
    <div class="faq-section bg-cover section-padding">
        <div class="container">
            <div class="row">
                @foreach ($data['faqs'] ?? [] as $index => $faq)
                    <div class="col-xl-6 col-lg-6 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <img class="card-img-top" src="{{ asset('assets/img/catalog2026.png') }}" alt="Catalog Image">
                            <div class="card-header bg-white border-0 pt-4 px-4">
                                <h5 class="card-title mb-0">
                                    <span class="badge bg-dark me-2">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    {{ $faq['question'] }}
                                </h5>
                            </div>
                            <div class="card-body px-4 pb-4">
                                <p class="card-text text-muted mb-0">
                                    @if ($faq['answer'] == 'CATALOG')
                                        <a href="{{ asset('assets/KirinCatalog.pdf') }}?key=202609" class="btn btn-link" target="_blank">
                                            Download Catalog
                                        </a>
                                    @else
                                        {{ $faq['answer'] }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection
