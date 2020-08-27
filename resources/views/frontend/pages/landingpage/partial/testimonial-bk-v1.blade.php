@if( !empty( $home_default->title_feedback ) || !empty( $home_default->content_feedback ) || ( !empty( $feedbacks ) && count( $feedbacks ) > 0 ) )
    @php
        if( !empty( $home_default->images_feedback ) ) {
            $img_bg = $home_default->images_feedback;
        }else {
            $img_bg = asset('assets/client/dist/img/bg/bg6.jpg');
        }
    @endphp
    <style type="text/css">
        .testimonial-section {
            background-image: url('{{ $img_bg }}');
        }
    </style>
    <div class="section-block-bg testimonial-section section-i-bg">
        <div class="container">
            <div class="section-heading center-holder">
                <h3>{{ $home_default->title_feedback ?? '' }}</h3>
                <div class="section-heading-line"></div>
                <p>{!! $home_default->content_feedback ?? '' !!}</p>
            </div>
            <div class="owl-carousel owl-theme" id="testmonials-carousel">
                @if( !empty( $feedbacks ) && count( $feedbacks ) > 0 )
                    @foreach( $feedbacks as $feedback )
                        @php
                            $images = !empty( $feedback->images ) ? $feedback->images : asset('assets/admin/dist/img/avatar5.png');
                        @endphp
                        <div class="testmonial-single">
                            <div class="row">
								<div class="col-md-3 col-sm-4 col-xs-12">
									<div class="image-box">
										<img src="{{ $images }}" title="{{ $feedback->title_image ?? '' }}" alt="{{ $feedback->alt_image ?? '' }}">
									</div>
								</div>
								<div class="col-md-9 col-sm-8 col-xs-12">
									{!! $feedback->description ?? '' !!}
									<h4>{{ $feedback->name_customer ?? '' }}</h4>
									@if( $feedback->position )
										<h6>{{ $feedback->position }}</h6>
									@endif
								</div>
							</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endif