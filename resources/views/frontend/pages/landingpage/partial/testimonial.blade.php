@if( !empty( $landingPage->title_feedback ) || !empty( $landingPage->content_feedback ) || ( !empty( $feedbacks ) && count( $feedbacks ) > 0 ) )
    @php
        if( !empty( $landingPage->images_feedback ) ) {
            $img_bg = $landingPage->images_feedback;
        }else {
            $img_bg = asset('assets/client/dist/img/client/back1.jpg');
        }
    @endphp
    <style type="text/css">
        .testimonial-section {
            background-image: url('{{ $img_bg }}');
        }
    </style>
    <!--Testimonial Area Start Here -->
    <div class="section-space-equal bg-common default-overlay testimonial-section" id="cam-nhan">
        @if( !empty( $landingPage->title_feedback ) || !empty( $landingPage->content_feedback ) )
        <div class="container">
            <div class="section-title-light">
                @if( !empty( $landingPage->title_feedback ) )
                    <h2>{{ $landingPage->title_feedback }}</h2>
                    <span><i class="fa fa-circle-o" aria-hidden="true"></i></span>
                @endif

                @if( !empty( $landingPage->content_feedback ) )
                    {!! $landingPage->content_feedback !!}
                @endif
            </div>
        </div>
        @endif

        @if( !empty( $feedbacks ) && count( $feedbacks ) > 0 )
        <div class="container">
            <div class="law-carousel nav-control-middle5" data-loop="true" data-items="3" data-margin="0" data-autoplay="false" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true"
                data-r-x-small-dots="false" data-r-x-medium="1" data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="1" data-r-small-nav="true" data-r-small-dots="false" data-r-medium="3" data-r-medium-nav="true" data-r-medium-dots="false">
                @foreach( $feedbacks as $feedback )
                    @php
                        $images = !empty( $feedback->images ) ? $feedback->images : asset('assets/admin/dist/img/avatar5.png');
                    @endphp

                    <div class="testimonial-box-layout1">
                        {!! $feedback->description ?? '' !!}

                        <a href="#"><img src="{{ $images }}" title="{{ $feedback->title_image ?? '' }}" alt="{{ $feedback->alt_image ?? '' }}" class="img-responsive img-circle"></a>

                        <h3 class="title-medium-light mb-none size-sm">{{ $feedback->name_customer ?? '' }}</h3>

                        @if( $feedback->position )
                            <div class="designation">{{ $feedback->position }}</div>
                        @endif
                    </div>

                @endforeach
            </div>
        </div>
        @endif
    </div>
    <!--Testimonial Area End Here -->
@endif
