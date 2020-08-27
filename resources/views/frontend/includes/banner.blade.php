@if( !empty( $related_sliders ) && count( $related_sliders ) > 0 )
<!-- Slider Area Start Here -->
<div id="fixed-type-slider" class="slider-area slider-layout-1 slider-overlay mt-148">
	<div class="bend niceties preview-1">
		<div id="ensign-nivoslider-3" class="slides">
		@if( !empty( $related_sliders[0] ) )
			@php
                $slider_images  = !empty( $related_sliders[0]->images ) ? json_decode( $related_sliders[0]->images ) : [];
                $title_image    = !empty( $related_sliders[0]->title_image ) ? json_decode( $related_sliders[0]->title_image ) : [];
                $alt_image      = !empty( $related_sliders[0]->alt_image ) ? json_decode( $related_sliders[0]->alt_image ) : [];
                $button_title   = !empty( $related_sliders[0]->button_title ) ? json_decode( $related_sliders[0]->button_title ) : [];
                $button_link    = !empty( $related_sliders[0]->button_link ) ? json_decode( $related_sliders[0]->button_link ) : [];
			@endphp

			@foreach( $slider_images as $key => $images )
                @php
                  $images = $images ?? asset('assets/admin/dist/img/no_image.png');
                @endphp

				<img src="{{ $images }}" alt="{{ $alt_image[$key] ?? '' }}" title="#slider-direction-{{ ( $key + 1 ) }}" />

			@endforeach
		@endif
		</div>

		@if( !empty( $related_sliders[0] ) )
			@php
                $slider_images  = !empty( $related_sliders[0]->images ) ? json_decode( $related_sliders[0]->images ) : [];
                $title_image    = !empty( $related_sliders[0]->title_image ) ? json_decode( $related_sliders[0]->title_image ) : [];
                $alt_image      = !empty( $related_sliders[0]->alt_image ) ? json_decode( $related_sliders[0]->alt_image ) : [];
                $button_title   = !empty( $related_sliders[0]->button_title ) ? json_decode( $related_sliders[0]->button_title ) : [];
                $button_link    = !empty( $related_sliders[0]->button_link ) ? json_decode( $related_sliders[0]->button_link ) : [];
			@endphp

			@foreach( $slider_images as $key => $images )

				<div id="slider-direction-{{ ( $key + 1 ) }}" class="t-cn slider-direction">
					<div class="slider-content s-tb slide-{{ ( $key + 1 ) }}">
						<div class="title-container s-tb-c title-textPrimary">
							@if( !empty( $title_image[ $key ] ) )
								<div class="top-title top-title-slide">{{ $title_image[ $key ] }}</div>
							@endif
							<div class="mid-title mid-title-slide hide">Providing Legal Help</div>

							@if( !empty( $button_link[ $key ] ) )
							<div class="slider-btn-area">
								<a href="{{ $button_link[ $key ] }}" class="btn-fill-primary">{{ $button_title[ $key ] ?? 'Xem Thêm' }}</a>
							</div>
							@endif
						</div>
					</div>
				</div>

			@endforeach
		@endif

	</div>
</div>
<!-- Slider Area End Here -->
@endif
