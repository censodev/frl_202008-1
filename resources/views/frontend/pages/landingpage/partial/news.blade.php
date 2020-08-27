@if( !empty( $home_default->title_news ) || ( !empty( $related_posts ) && count( $related_posts ) > 0 ) )
<div class="section-block news-section section-i-bg">
    <div class="container">
        <div class="section-heading center-holder">
            <h3>{{ $home_default->title_news ?? '' }}</h3>
            <div class="section-heading-line"></div>
        </div>
        <div class="row mt-50">
            @if( !empty( $related_posts ) && count( $related_posts ) > 0 )
                @foreach( $related_posts as $post )
                    @php
                        $images         = $post->images ?? asset('assets/admin/dist/img/no_image.png');
                        $title_image    = $post->title_image ?? $post->title;
                        $alt_image      = $post->alt_image ?? $post->title;

                        if( !empty( $post->created_at ) ) {
                            $created_at = date_create($post->created_at);
                            $post_date  = date_format($created_at,"d/m/Y");
                        }else {
                            $post_date = '';
                        }
                    @endphp

                    <div class="col-md-4 col-sm-4 col-12">
                        <div class="service-simple">
                            <img src="{{ $images }}" title="{{ $title_image }}" alt="{{ $alt_image }}">
                            <div class="service-simple-inner">
                                <a href="{{ url( $post->alias ) }}"><h4>{{ $post->title ?? '' }}</h4></a>
                                <p>{!! $post->seo_desciption !!}</p>
                                <div class="service-simple-button"> <a href="{{ url( $post->alias ) }}">Xem Thêm</a> </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endif