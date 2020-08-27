@if( !empty( $landingPage->title_funfact ) || !empty( $count_funfact ) )
    @if( !empty( $landingPage->images_funfact ) )
        <style type="text/css">
            .counter-section {
                background-image: url('{{ $landingPage->images_funfact  }}');
            }
        </style>
    @endif

    <!--Counter Layout start Here -->
    <div class="bg-box section-space-counter counter-section" id="thong-ke">
        @if( !empty( $landingPage->title_funfact ) || !empty( $landingPage->content_funfact ) )
        <div class="container">
            <div class="section-title-light">
                @if( !empty( $landingPage->title_funfact ) )
                <h2>{{ $landingPage->title_funfact }}</h2>
                <span><i class="fa fa-circle-o" aria-hidden="true"></i></span>
                @endif

                @if( !empty( $landingPage->content_funfact ) )
                    {!! $landingPage->content_funfact ?? '' !!}
                @endif
            </div>
        </div>
        @endif
        <div class="container">
            <div class="row">
                @if( !empty( $count_funfact ) )
                    @foreach( $funfact_number as $key => $ff_number )
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-mb-12">
                            <div class="counter-box-layout1">
                                {!! $funfact_icon[$key] !!}
                                <h3 class="counter" data-num="{{ $ff_number ?? 0 }}">{{ $ff_number ?? 0 }}</h3>
                                <p>{!! $funfact_description[$key] ?? '' !!}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!--Counter Layout end here -->

@endif
