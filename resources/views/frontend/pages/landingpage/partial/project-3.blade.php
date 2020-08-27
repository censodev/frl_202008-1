@if( !empty( $home_default->title_gallery ) || ( !empty( $related_galleries ) && count( $related_galleries ) > 0 && !empty( $related_galleries[0] ) ) )
<section class="projects-3-section section-i-bg">
    <div class="auto-container">
		<div class="section-heading center-holder">
            <h3>{{ $home_default->title_gallery ?? '' }}</h3>
            <div class="section-heading-line"></div>
        </div>
    </div>

    <div class="services-box mt-50">
		<div class="container">	
			<div class="projects-carousel owl-carousel owl-theme">

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

						<!-- Project Block -->
						<div class="project-block">
							<div class="image-box">
								<figure class="image"><img src="{{ $image_first }}" title="{{ $gallery->title ?? '' }}" alt="{{ $gallery->title ?? '' }}"></figure>
								<div class="overlay-box">
									<h4><a href="{{ url( $gallery->alias ) }}">{{ $gallery->title ?? '' }}</a></h4>
									<div class="btn-box">
										<a href="{{ $image_first }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
										<a href="{{ url( $gallery->alias ) }}"><i class="fa fa-external-link"></i></a>
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