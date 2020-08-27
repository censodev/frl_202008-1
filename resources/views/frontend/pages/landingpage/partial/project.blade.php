@if( !empty( $home_default->title_gallery ) || ( !empty( $related_galleries ) && count( $related_galleries ) > 0 && !empty( $related_galleries[0] ) ) )
<section class="section-block projects-section section-i-bg">
    <div class="container">
        <div class="section-heading center-holder">
            <h3>{{ $home_default->title_gallery ?? '' }}</h3>
            <div class="section-heading-line"></div>
        </div>
    </div>

    <div class="inner-container mt-50">
        <div class="container">
            <div class="projects-carousel owl-carousel owl-theme">

                @if( !empty( $related_galleries ) && count( $related_galleries ) > 0 && !empty( $related_galleries[0] ) )
                    @php
                        $galleries              = $related_galleries[0];
                        $gallery_images         = !empty( $galleries->images ) ? json_decode( $galleries->images ) : [];
                        $gallery_title_image    = !empty( $galleries->title_image ) ? json_decode( $galleries->title_image ) : [];
                        $gallery_alt_image      = !empty( $galleries->alt_image ) ? json_decode( $galleries->alt_image ) : [];
                    @endphp

                    @foreach( $gallery_images as $key => $gallery )
                        <!-- Project Block -->
                        <div class="project-block">
                            <div class="image-box">
                                <figure class="image"><img src="{{ $gallery }}" title="{{ $gallery_title_image[$key] ?? '' }}" alt="{{ $gallery_alt_image[$key] ?? '' }}"></figure>
                                <div class="overlay-box">
                                    <h4><a href="{{ url( $galleries->alias ) }}">{{ $gallery_title_image[$key] ?? '' }}</a></h4>
                                    <div class="btn-box">
                                        <a href="{{ $gallery }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
                                        <a href="{{ url( $galleries->alias ) }}"><i class="fa fa-external-link"></i></a>
                                    </div>
                                    <span class="tag hide">Architecture</span>
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