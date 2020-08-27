@if( !empty( $home_default->title_post_hot ) || !empty( $home_default->content_post_hot ) || ( !empty( $related_posts ) && count( $related_posts ) > 0 ) )
    <div class="ereaders-main-section ereaders-blog-gridfull">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ereaders-fancy-title">
                    <h2 class="bounceIn wow">{{ $home_default->title_post_hot }}</h2>
                    <div class="clearfix"></div>
                    <div class="fadeInRight wow">
                        {!! $home_default->content_post_hot !!}
                    </div>
                </div>
                <div class="ereaders-blog ereaders-blog-grid fadeInUp wow">
                    <ul class="row">
                        @foreach($related_posts as $key => $item)
                            @php
                                if( !empty( $item->created_at ) ) {
                                    $created_at = date_create($item->created_at);
                                    $post_date  = date_format($created_at,"d/m/Y");
                                }else {
                                    $post_date = '';
                                }
                            @endphp
                            <li class="col-md-4">
                                <div class="ereaders-blog-grid-wrap">
                                    <figure><a href="{{ url( $item->alias ) }}"><img src="{{ $item->images }}" alt="{{ $item->alt_image }}" title="{{ $item->title_image }}" ></a></figure>
                                    <div class="ereaders-blog-grid-text">
                                        <h3><a href="{{ url( $item->alias ) }}">{{ $item->title }}</a></h3>
                                        {!! $item->sapo  !!}
                                        <ul class="ereaders-blog-option">
                                            <li><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post_date }}</li>
                                            <li><i class="fa fa-eye" aria-hidden="true"></i> {{ $item->view }}</li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i> {{ $item->rating }}</li>
                                        </ul>
                                        <a href="{{ url( $item->alias ) }}" class="ereaders-readmore-btn">Chi Tiết <i class="fa fa-angle-double-right"></i></a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
