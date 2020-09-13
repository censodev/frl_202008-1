@if( !empty( $home_default->title_hot ) || !empty( $home_default->description_hot ) || !empty( $related_hots ))
<div class="ereaders-main-section ereaders-hot-category-gridfull">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ereaders-fancy-title">
                    <h1 class="bounceIn wow">{{ $home_default->title_hot }}</h1>
                    <div class="clearfix"></div>
                    <div class="fadeInRight wow">
                        {!! $home_default->description_hot !!}
                    </div>
                </div>
                <div class="ereaders-blog ereaders-blog-grid fadeInUp wow">
                    <ul class="row">

                        @if( !empty( $related_hots ) && count( $related_hots ) > 0 )
                            @foreach( $related_hots as $hot )
                                @php
                                    $images = !empty( $hot->images ) ? $hot->images : asset('assets/admin/dist/img/avatar5.png');
                                @endphp
                                <li class="col-md-3">
                                    <div class="ereaders-blog-grid-wrap">
                                        <figure><a href="{{ $hot->link }}" title="{{ $hot->link_title }}"><img src="{{ $images }}" title="{{ $hot->title_image }}" alt="{{ $hot->alt_image }}"></a></figure>
                                        <div class="ereaders-blog-grid-text">
                                            <h2><a href="{{ $hot->link }}" title="{{ $hot->name }}">{{ $hot->name }}</a></h2>
                                            <p>{{ $hot->description }}</p>
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
