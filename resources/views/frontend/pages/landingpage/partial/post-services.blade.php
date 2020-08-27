@if( !empty( $landingPage->title_service ) || ( !empty( $related_posts_service ) && count( $related_posts_service ) > 0 ) )
    @if( !empty( $landingPage->images_service ) )
        <style type="text/css">
            .post-service-section {
                background-image: url('{{ $landingPage->images_service  }}');
            }
        </style>
    @endif

    <!-- Case Result Layout1 Start Here -->
    <div class="case-result-layout1 section-space default-overlay bg-common post-service-section" id="linh-vuc" >
        <div class="container">
            @if( !empty( $landingPage->title_service ) || !empty( $landingPage->content_service ) )
            <div class="section-title-light">
                @if( !empty( $landingPage->title_service ) )
                    <h2>{{ $landingPage->title_service }}</h2>
                    <span><i class="fa fa-circle-o" aria-hidden="true"></i></span>
                @endif

                @if( !empty( $landingPage->content_service ) )
                    {!! $landingPage->content_service !!}
                @endif
            </div>
            @endif

            @if( !empty( $related_posts_service ) && count( $related_posts_service ) > 0 )
            <div class="row">
                @php $i = 1; @endphp
                @foreach( $related_posts_service as $key => $post_service )
                @php
                        $images = $post_service->images ?? asset('assets/admin/dist/img/no_image.png');

                    @endphp
                    @if(!empty($post_service))
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-mb-12 wow fadeIn" data-wow-duration="2s" data-wow-delay=".{{ ( 2 * $i + 1) }}s">
                            <div class="case-result-box1 item-mb">
                                <div class="item-img">
                                    <img src="{{ $images }}" class="img-responsive width-100">
                                    <div class="item-content">
                                        {{$services_description[$key]}}
                                    </div>
                                </div>
                                <h3 class="title-regular-dark"><a href="{{$services_url[$key]}}">{{ $post_service}}</a></h3>
                            </div>
                        </div>
                    @endif
                    @php $i++; @endphp
                @endforeach
            </div>
            @endif

        </div>
    </div>
    <!-- Case Result Layout end Here -->

@endif
