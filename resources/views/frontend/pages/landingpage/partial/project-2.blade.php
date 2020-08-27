@if( !empty( $home_default->title_gallery ) || ( !empty( $related_galleries ) && count( $related_galleries ) > 0 && !empty( $related_galleries[0] ) ) )
<style type="text/css">
    .projects-2-section .upper-box {
        background-image: url({{ asset('assets/client/dist/images/background/2.jpg') }});
    }
</style>
<section class="section-block projects-2-section section-p-bg section-i-bg">
    <div class="upper-box">
        <div class="container">
            <div class="section-heading center-holder">
                <h3>{{ $home_default->title_gallery ?? '' }}</h3>
                <div class="section-heading-line"></div>
            </div>
        </div>
    </div>

    <div class="services-box mt-50">
        <div class="container">
            <div class="services-carousel owl-carousel owl-theme">

                @if( !empty( $related_galleries ) && count( $related_galleries ) > 0 && !empty( $related_galleries[0] ) )
                    @foreach( $related_galleries as $gallery )
                        @php
                            $images      = !empty( $gallery->images ) ? json_decode( $gallery->images ) : [];
                            $title_image = !empty( $gallery->title_image ) ? json_decode( $gallery->title_image ) : [];
                            $alt_image   = !empty( $gallery->alt_image ) ? json_decode( $gallery->alt_image ) : [];

                            $image_first        = !empty( $images[0] ) ? $images[0] : asset('assets/admin/dist/img/no_image.png');
                            $title_image_first  = !empty( $title_image[0] ) ? $title_image[0] : '';
                            $alt_image_first    = !empty( $alt_image[0] ) ? $alt_image[0] : '';
                        @endphp

                        <!-- Service Block -->
                        <div class="service-block">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image"><a href="{{ url( $gallery->alias ) }}"><img src="{{ $image_first }}" title="{{ $title_image_first }}" alt="{{ $alt_image_first }}"></a></figure>
                                </div>
                                <div class="lower-content">
                                    <h3><a href="{{ url( $gallery->alias ) }}">{{ $gallery->title }}</a></h3>
                                    <div class="text">{!! $gallery->seo_desciption !!}</div>
                                    <div class="link-box">
                                        <a href="{{ url( $gallery->alias ) }}">Xem Thêm <i class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</section>
@endif