<div id="slideshow-menu p-0">
    <div class="row wp-slideshow-menu" >
        {{-- <div class="col-lg-3 wp-menu">
            @include('frontend.pages.home.partial.sidebar-menu')
        </div> --}}
        <div class="col-md-12">
            <div class="ereaders-banner">
                @if( !empty( $related_sliders ) && count( $related_sliders ) > 0 )
                    @if( !empty( $related_sliders[0] ) )
                        @php
                            $slider_images  = !empty( $related_sliders[0]->images ) ? json_decode( $related_sliders[0]->images ) : [];
                            $title_image    = !empty( $related_sliders[0]->title_image ) ? json_decode( $related_sliders[0]->title_image ) : [];
                            $alt_image      = !empty( $related_sliders[0]->alt_image ) ? json_decode( $related_sliders[0]->alt_image ) : [];
                            $button_title   = !empty( $related_sliders[0]->button_title ) ? json_decode( $related_sliders[0]->button_title ) : [];
                            $button_link    = !empty( $related_sliders[0]->button_link ) ? json_decode( $related_sliders[0]->button_link ) : [];
                        @endphp

                        @foreach( $slider_images as $key => $images )
                            <div class="ereaders-banner-layer">
                                <img src="{{ $images }}" alt="{{ $alt_image[$key] }}" title="{{ $title_image[$key] }}" style="width: 100%;">
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>


