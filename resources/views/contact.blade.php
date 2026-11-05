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

    <div class="contact-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-5">
                    <div class="contact-info">
                        <div class="section-title">
                            <h2 class="visible-slowly-right">Contact Us</h2>
                        </div>
                        <div class="contact-info-inner">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="contact-text">
                                        <p>{{ $data['contact_text'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="single-contact-info wow fadeInUp animated" data-wow-delay="200ms">
                                <p>Email</p>
                                <h4><a href="mailto:{{ $data['email'] }}" style="color: inherit; font-size: inherit;">{{ $data['email'] }}</a></h4>
                            </div>
                            <div class="single-contact-info wow fadeInUp animated" data-wow-delay="400ms">
                                <p>Phone</p>
                                <h4><a href="tel:{{ preg_replace('/[^\d+]/', '', $data['phone']) }}" style="color: inherit; font-size: inherit;">{{ $data['phone'] }}</a></h4>
                            </div>
                            <div class="single-contact-info wow fadeInUp animated" data-wow-delay="600ms">
                                <p>Address</p>
                                <h4>{{ $data['address'] }}</h4>
                            </div>
                            <div class="social-area">
                                <a href="{{ $data['social_facebook'] }}"><i class="fab fa-facebook-f"></i></a>
                                <a href="{{ $data['social_instagram'] }}"><i class="fab fa-instagram"></i></a>
                                <a href="{{ $data['social_linkedin'] }}"><i class="fab fa-linkedin-in"></i></a>
                                <a href="{{ $data['social_skype'] }}"><i class="fab fa-skype"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offset-xl-1 col-xl-6 offset-lg-1 col-lg-6">
                    <div class="subimit-form-wrap">
                        <div class="section-title">
                            <h2 class="visible-slowly-right">Submit Form</h2>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <form action="{{ route('contact_us.store') }}" method="POST">
                            @csrf
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Your Name" required>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                            <textarea name="message" cols="30" rows="10" placeholder="Message" required>{{ old('message') }}</textarea>
                            <input type="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
            <div class="google-map mt-60">
                <!--<iframe-->
                <!--    src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3690.404245521138!2d91.80989606467384!3d22.338360085303748!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sdewanhat%20near%20Chattogram!5e0!3m2!1sen!2sbd!4v1677069314806!5m2!1sen!2sbd"-->
                <!--    width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"-->
                <!--    referrerpolicy="no-referrer-when-downgrade"></iframe>-->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.647291495214!2d79.87836539999999!3d6.9326919999999985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae259a8e673010d%3A0xf455b6610f7d1aac!2s752%2C%20414%2F1%2F1%20Dr%20Danister%20De%20Silva%20Mawatha%2C%20Colombo%2000900!5e0!3m2!1sen!2slk!4v1766114930497!5m2!1sen!2slk" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>
    </div>

@endsection
