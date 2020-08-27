@if( !empty( $home_default->title_newspaper ) || !empty( $home_default->description_newspaper ) || !empty( $related_newspapers ))
    <div class="ereaders-main-section ereaders-blog-gridfull">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="ereaders-fancy-title">
                    <h2 class="bounceIn wow">{{ $home_default->title_newspaper }}</h2>
                    <div class="clearfix"></div>
                    <div class="fadeInLeft wow">
                        {!! $home_default->description_newspaper !!}
                    </div>
                </div>
                <div class="ereaders-blog ereaders-blog-grid fadeInLeft wow">
                    <ul class="row">

                        @if( !empty( $related_newspapers ) && count( $related_newspapers ) > 0 )
                            @foreach( $related_newspapers as $new )
                                @php
                                    $images = !empty( $new->images ) ? $new->images : asset('assets/admin/dist/img/avatar5.png');
                                @endphp
                                <li class="col-md-6">
                                    <div class="ereaders-blog-grid-wrap">
                                        <figure><img src="{{ $images }}" alt="{{ $new->alt_image }}" title="{{ $new->title_image }}"></figure>
                                        <div class="ereaders-blog-grid-text">
                                            <h2><a href="{{ $new->link }}" title="{{ $new->name }}">{{ $new->name }}</a></h2>
                                            <div>
                                                {!! substr($new->description,0,75) !!}
                                            </div>
                                            <a href="{{ $new->link }}" title="{{ $new->name }}" class="ereaders-readmore-btn">Chi Tiết <i class="fa fa-angle-double-right"></i></a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif

                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ereaders-fancy-title">
                    <h2 class="bounceIn wow">{{ $home_default->title_tv }}</h2>
                    <div class="clearfix"></div>
                    <div class="fadeInRight wow">
                        {!! $home_default->description_tv !!}
                    </div>
                </div>
                <div class="ereaders-blog ereaders-blog-grid fadeInRight wow">
                    <ul class="row">

                        @if( !empty( $related_tvs ) && count( $related_tvs ) > 0 )
                            @foreach( $related_tvs as $tv )
                                @php
                                    $images = !empty( $tv->images ) ? $tv->images : asset('assets/admin/dist/img/avatar5.png');
                                @endphp
                                <li class="col-md-6">
                                    <div class="ereaders-blog-grid-wrap">
                                        <figure>
                                            <div class="show_video" data-video="{{ $tv->link }}" data-name="{{ $tv->name }}" style="cursor: pointer;">
                                                <img src="{{ $images }}" alt="{{ $tv->alt_image }}" title="{{ $tv->title_image }}">
                                            </div>
                                        </figure>
                                        <div class="ereaders-blog-grid-text">
                                            <h2><a href="{{ $tv->link }}" title="{{ $tv->link_title }}" target="_blank">{{ $tv->name }}</a></h2>
                                            <p>{{ $tv->name_video }}</p>
                                            <a href="{{ $tv->link }}" title="{{ $tv->link_title }}" class="ereaders-readmore-btn" target="_blank">Chi Tiết <i class="fa fa-angle-double-right"></i></a>
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

    <div id="myModalVideo" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="content-video">
                        <iframe width="644" height="362" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="">
                        </iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>

        </div>
    </div>
</div>
@endif
