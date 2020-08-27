@extends($data->layout, [
    'title'             => $data['title'],
    "seo_title"         => $data['seo_title'],
    'og_image'          => $data['og_image'],
    'og_url'            => $data['og_url'],
    'seo_description'   => $data['seo_description'],
    'seo_keywords'      => $data['seo_keywords']
])

@section('title')
    {{ $data->title }}
@endsection
@php
    $contact = $data['contact'];
    $contact_info = json_decode( $contact->contact_info ) ?? array();
    $images_background = $data['contact']->images_background;
    $footer_contact_info    = !empty( $footers->footer_contact_info ) ? json_decode( $footers->footer_contact_info ) : [];
@endphp

@section($data->content)

    @if( !empty($images_background) )
        <style>
            .background-category > div{
                background: url("{{ $images_background }}");
                background-size: cover;
                background-repeat: no-repeat;
            }
        </style>
    @endif

<div id="slideshow-menu">
    <div class="container wp-breadcrumb">
        <div class="row wp-slideshow-menu">
            <div class="col-md-3">
                @include('frontend.pages.home.partial.sidebar-menu')
            </div>
            <div class="col-md-9 background-category">
            </div>
        </div>
    </div>
</div>
<div class="ereaders-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul>
                    <li><a href="/" title="trang chủ">Trang chủ</a></li>
                    <li class="active">{{ $data->title }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>



    <div class="ereaders-main-content">

        <div class="ereaders-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 google-map" id="google-map">
                        @if( !empty( $contact->google_map ) )
                            {!! $contact->google_map !!}
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h2 class="ereaders-section-heading">Thông Tin</h2>
                        <div class="ereaders-about-education">
                            <ul>
                                <li>
                                    <span></span>
                                    <h6>Địa chỉ</h6>
                                    <p>{{ $contact_info[0] }}</p>
                                </li>
                                <li>
                                    <span></span>
                                    <h6>Số Điện thoại</h6>
                                    <a href="tel:{{ $contact_info[2] }}" title="{{ $contact_info[2] }}">{{ $contact_info[2] }}</a>
                                </li>
                                <li>
                                    <span></span>
                                    <h6>Hotline</h6>
                                    <a href="tel:{{ $footer_contact_info[3] }}" title="{{ $footer_contact_info[3] }}">{{ $footer_contact_info[3] }}</a>
                                </li>
                                <li>
                                    <span></span>
                                    <h6>Email</h6>
                                    <a href="mailto:{{ $contact_info[1] }}" title="{{ $contact_info[1] }}">{{ $contact_info[1] }}</a>
                                </li>
                                <li>
                                    <span></span>
                                    <h6>Mở Cửa</h6>
                                    <a href="#" title="{{ $footer_contact_info[2] }}">{{ $footer_contact_info[2] }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ereaders-contact-form">
                            <h2 class="ereaders-section-heading">Liên Hệ Chúng Tôi</h2>
                            <form id="contact-form" action="{{ route('contact_submit') }}" method="post" class="myform">
                                {{csrf_field()}}
                                <input type="hidden" name="alias_contact" value="{{ url()->current() }}">
                                <ul>
                                    <li>
                                        <input value="{{ old('fullname') }}" type="text" name="fullname" placeholder="Họ tên" required>
                                        <i class="fa fa-user"></i>
                                    </li>
                                    <li>
                                        <input value="{{ old('email') }}" type="text" name="email" placeholder="Email" required>
                                        <i class="fa fa-envelope"></i>
                                    </li>
                                    <li>
                                        <input value="{{ old('phone') }}" type="text" name="phone" placeholder="Số điện thoại" required>
                                        <i class="fa fa-phone"></i>
                                    </li>
                                    <li>
                                        <input value="{{ old('address') }}" type="text" name="phone" placeholder="Địa Chỉ" required>
                                        <i class="fa fa-map-marker"></i>
                                    </li>
                                    <li class="full-form">
                                        <textarea placeholder="Lời nhắn" name="message"></textarea>
                                        <i class="fa fa-pencil-square-o"></i>
                                    </li>
                                    <li class="full-width">
                                        <input type="submit" name="submit" value="Send Now">
                                        <span class="output_message"></span>
                                    </li>
                                </ul>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
