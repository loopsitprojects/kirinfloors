@extends('layouts.public')

@section('title', $post->meta_data['meta_title'] ?? 'Kirin Flooring | Premium SPC & Click-Lock Flooring')

@section('meta')
    <meta name="description"
        content="{{ $post->meta_data['meta_description'] ?? 'Premium SPC and click-lock flooring solutions for homes and businesses. Expert installation services with decades of experience.' }}">
    <meta name="keywords" content="{{ $post->meta_data['meta_keywords'] ?? 'flooring, SPC, click-lock, installation, Kirin' }}">
    @foreach ($post->meta_data['custom_meta_tags'] ?? [] as $tag)
        <meta {{ $tag['attribute'] }}="{{ $tag['key'] }}" content="{{ $tag['content'] }}">
    @endforeach
@endsection

@section('styles')
    <style>
        #blog-page .rich-content {
            color: #797c7f;
            font-size: 17px;
            line-height: 1.75;
        }

        #blog-page .rich-content > :first-child {
            margin-top: 0;
        }

        #blog-page .rich-content > :last-child {
            margin-bottom: 0;
        }

        #blog-page .rich-content p {
            margin: 0 0 1.25rem;
            color: inherit;
            font-size: inherit;
            line-height: inherit;
        }

        #blog-page .rich-content h1,
        #blog-page .rich-content h2,
        #blog-page .rich-content h3,
        #blog-page .rich-content h4,
        #blog-page .rich-content h5,
        #blog-page .rich-content h6 {
            margin: 2rem 0 1rem;
            color: #181818;
            font-weight: 500;
            line-height: 1.3;
        }

        #blog-page .rich-content h1 {
            font-size: 2.5rem;
        }

        #blog-page .rich-content h2 {
            font-size: 2rem;
        }

        #blog-page .rich-content h3 {
            font-size: 1.5rem;
        }

        #blog-page .rich-content h4 {
            font-size: 1.25rem;
        }

        #blog-page .rich-content h5 {
            font-size: 1.125rem;
        }

        #blog-page .rich-content h6 {
            font-size: 1rem;
        }

        #blog-page .rich-content ul,
        #blog-page .rich-content ol {
            margin: 0 0 1.5rem;
            padding-left: 1.75rem;
        }

        #blog-page .rich-content ul {
            list-style-type: disc;
        }

        #blog-page .rich-content ol {
            list-style-type: decimal;
        }

        #blog-page .rich-content ul ul {
            list-style-type: circle;
        }

        #blog-page .rich-content ul ul ul {
            list-style-type: square;
        }

        #blog-page .rich-content li {
            margin-bottom: 0.25rem;
            line-height: 1.75;
        }

        #blog-page .rich-content li > ul,
        #blog-page .rich-content li > ol {
            margin-top: 0.5rem;
            margin-bottom: 0;
        }

        #blog-page .rich-content li > p {
            margin-bottom: 0.25rem;
        }

        #blog-page .rich-content li > p:last-child {
            margin-bottom: 0;
        }
        #blog-page .rich-content a {
            display: inline;
            color: #b58a33;
            font-size: inherit;
            font-weight: 500;
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 3px;
        }

        #blog-page .rich-content a:hover {
            color: #8f6a22;
            text-decoration-thickness: 2px;
        }

        #blog-page .rich-content img {
            max-width: 100%;
            height: auto;
        }

        #blog-page .rich-content blockquote {
            margin: 0 0 1.5rem;
            padding: 0.25rem 0 0.25rem 1.25rem;
            border-left: 4px solid var(--brand-gold);
            color: #555;
            font-style: italic;
        }

        #blog-page .rich-content hr {
            margin: 2rem 0;
            border: 0;
            border-top: 1px solid #e5e5e5;
        }

        @media (max-width: 767px) {
            #blog-page .rich-content {
                font-size: 16px;
            }

            #blog-page .rich-content h1 {
                font-size: 2rem;
            }

            #blog-page .rich-content h2 {
                font-size: 1.65rem;
            }

            #blog-page .rich-content h3 {
                font-size: 1.35rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb Area  -->
    <div class="breadcrumb-area" style="background-image: url({{ Storage::publicUrl($post->image_path) }});">
        <div class="overlay-5"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="breadcrumb-title">
                        <h1>{{ $post->title }}</h1>
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
            <div class="rich-content">
                {{ \Filament\Forms\Components\RichEditor\RichContentRenderer::make($post->content)->fileAttachmentsDisk('public') }}
            </div>
        </div>
    </div>
@endsection
