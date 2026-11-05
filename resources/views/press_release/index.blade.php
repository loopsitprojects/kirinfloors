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
    <div class="breadcrumb-area" style="background-image: url({{ asset('assets/img/pr-bg.png') }});">
        <div class="overlay-5"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="breadcrumb-title">
                        <h1>Press Releases</h1>
                    </div>
                    <div class="breadcrumb-icon">
                        <i class="las la-angle-down"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Section -->
    <div id="blog-page" class="blog-section section-padding pb-60">
        <div class="container">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp animated" data-wow-delay="200ms">
                        <div class="single-blog-item">
                            <div class="blog-img">
                                <img src="{{ Storage::publicUrl($post->image_path) }}" alt="">
                            </div>
                            <div class="blog-meta">
                                <span>{{ $post->category }}</span>
                            </div>
                            <div class="blog-title">
                                <h5>{{ $post->title }}</h5>
                            </div>
                            <div class="blog-content">
                                <p>{{ $post->short_description }}</p>
                            </div>
                            <a href="{{ route('press-release.show', Str::slug($post->title) . '-' . $post->id) }}" class="read-more-btn bordered-btn">Read More</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
