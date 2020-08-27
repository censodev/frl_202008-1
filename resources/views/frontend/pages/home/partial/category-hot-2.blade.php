@if( !empty( $home_default->title_hot_2 ) || !empty( $home_default->description_hot_2 ) || !empty( $related_hot2s ))
<div class="ereaders-main-section ereaders-hot-category-2-gridfull">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ereaders-fancy-title">
                    <h2 class="bounceIn wow">{{ $home_default->title_hot_2 }}</h2>
                    <div class="clearfix"></div>
                    <div class="fadeInRight wow">
                        {!! $home_default->description_hot_2 !!}
                    </div>
                </div>
                <div class="ereaders-blog ereaders-blog-grid fadeInUp wow">
                    <ul class="row">

                        @if( !empty( $related_hot2s ) && count( $related_hot2s ) > 0 )
                            @foreach( $related_hot2s as $hot )
                                @php
                                    $images = !empty( $hot->images ) ? $hot->images : asset('assets/admin/dist/img/avatar5.png');
                                @endphp
                                <li class="col-md-3">
                                    <div class="ereaders-blog-grid-wrap">
                                        <figure><a href="{{ $hot->link }}" title="{{ $hot->link_title }}"><img src="{{ $images }}" alt="{{ $hot->alt_image }}" title="{{ $hot->title_image }}"></a></figure>
                                        <div class="ereaders-blog-grid-text">
                                            <h2><a href="{{ $hot->link }}" title="{{ $hot->name }}">{{ $hot->name }}</a></h2>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif


                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
