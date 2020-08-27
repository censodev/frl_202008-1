@if( !empty( $related_partners ) && count( $related_partners ) > 0 )
<!-- Brand Area Start Here -->

<div class="s-space-brand bg-box" id="doi-tac">
	<div class="container">
		<div class="section-title-light">
			<h2 style="color :black">{{$landingPage->title_partner}}</h2>
			<span><i class="fa fa-circle-o" aria-hidden="true"></i></span>
			@if (!empty($landingPage->description_partner))
				<p style="color:black;">{{$landingPage->description_partner}}</p>
			@endif

		</div>
		<div class="law-carousel nav-control-middle3" data-loop="true" data-items="6" data-margin="30" data-autoplay="true" data-autoplay-timeout="5000" data-smart-speed="2000" data-dots="false" data-nav="false" data-nav-speed="false" data-r-x-small="2" data-r-x-small-nav="false"
			data-r-x-small-dots="false" data-r-x-medium="3" data-r-x-medium-nav="false" data-r-x-medium-dots="false" data-r-small="4" data-r-small-nav="false" data-r-small-dots="false" data-r-medium="6" data-r-medium-nav="false" data-r-medium-dots="false">
			@foreach( $related_partners as $partner )
                @php
                    $images = $partner->images ?? asset('assets/admin/dist/img/no_image.png');
                    $link_title   = !empty( $partner->link_title ) ? $partner->link_title : $partner->name;
                    $title_image  = !empty( $partner->title_image ) ? $partner->title_image : $partner->name;
                    $alt_image    = !empty( $partner->alt_image ) ? $partner->alt_image : $partner->name;
                @endphp

				<div class="brand-box">
					@if( !empty( $partner->link ) )
						<a href="{{ $partner->link }}" title="{{ $link_title }}">
							<img src="{{ $images }}" title="{{ $title_image }}" alt="{{ $alt_image }}">
						</a>
					@else
						<img src="{{ $images }}" title="{{ $title_image }}" alt="{{ $alt_image }}">
					@endif
				</div>
			@endforeach
		</div>
	</div>
</div>
<!-- Brand Area End Here -->
@endif
