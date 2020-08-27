@if( !empty( $landingPage->title_about ) || !empty( $landingPage->images_about ) || !empty( $landingPage->video_about ) || !empty( $landingPage->content_about ) )
<!-- About Layout Start Here -->
<div class="section-space-service" id="gioi-thieu">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 mb--sm wow fadeIn" data-wow-duration="2s" data-wow-delay=".5s">
				@if( !empty( $landingPage->title_about ) )
					<h1 class="title-bold-dark mb-40">{{ $landingPage->title_about }}</h1>
				@endif

				{!! $landingPage->content_about ?? '' !!}

				@if( !empty( $landingPage->title_button_about ) )
					@if( !empty( $landingPage->button_link_about ) )
						<a href="{{ $landingPage->button_link_about }}" class="btn-fill-primary2 mt-30">{{ $landingPage->title_button_about }}</a>
					@else
						<button class="btn-fill-primary2 mt-30">Liên Hệ</button>
					@endif
				@endif
			</div>
			<div class="col-lg-6 col-md-5 col-sm-12 col-xs-12 wow bounceInRight" data-wow-duration="2s" data-wow-delay=".6s">
				@if( !empty( $landingPage->video_about ) )
                    {!! $landingPage->video_about !!}
                @elseif( !empty( $landingPage->images_about ) )
                    <img src="{{ $landingPage->images_about }}" class="img-responsive m-auto" title="{{ $landingPage->title_about ?? '' }}" alt="{{ $landingPage->title_about ?? '' }}">
                @endif
			</div>
		</div>
	</div>
</div>
<!-- About Layout End Here -->
@endif
