@if( !empty( $landingPage->title_why ) || !empty( $count_why ) )
	@if( !empty( $landingPage->images_why ) )
        <style type="text/css">
            .why-area {
                background-image: url('{{ $landingPage->images_why  }}');
            }
        </style>
    @endif
	<!-- Choose Layout start Here -->
	<div class="section-space55 bg-accent why-area" id="ly-do">
		@if( !empty( $landingPage->title_why ) || !empty( $landingPage->content_why ) )
		<div class="container">
			<div class="section-title-light">
				@if( !empty( $landingPage->title_why ) )
					<h2>{{ $landingPage->title_why }}</h2>
					<span><i class="fa fa-circle-o" aria-hidden="true"></i></span>
				@endif

				@if( !empty( $landingPage->content_why ) )
					{!! $landingPage->content_why !!}
				@endif
			</div>
		</div>
		@endif

		@if( !empty( $count_why ) )
		<div class="container">
			<div class="row">
				@foreach( $why_title as $key => $w_title )
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-mb-12 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s">
						<div class="choose-box-layout1">
							<h3 class="title-regular-light">
								@if( !empty( $why_icon[$key] ) )
									<span>
										{!! $why_icon[$key] !!}
									</span>
								@else
									<span> {{ ( $key + 1 ) }}. </span>
								@endif

								{{ $w_title ?? '' }}
							</h3>

							@if( !empty( $why_description[$key] ) )
								<p>{!! $why_description[$key] ?? '' !!}</p>
							@endif
						</div>
					</div>
				@endforeach
			</div>
		</div>
		@endif
	</div>
	<!--Choose Layout end here  -->
@endif
