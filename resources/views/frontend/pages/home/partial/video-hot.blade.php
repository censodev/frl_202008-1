@if (!empty($home_default->title_video_hot) || !empty($home_default->content_video_hot))
    <div class="ereaders-main-section ereaders-blog-gridfull">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ereaders-fancy-title">
                        <h2 class="bounceIn wow">{{ $home_default->title_video_hot }}</h2>
                        <div class="clearfix"></div>
                        <div class="fadeInRight wow">
                            {!! $home_default->content_video_hot !!}
                        </div>
                    </div>
                    <div class="ereaders-blog ereaders-blog-grid fadeInUp wow">
                        <ul class="row">
                            @foreach ($video_hot_title as $k => $v_title)
                                @if ($v_title)
                                <li class="col-md-4">
                                    <div class="ereaders-blog-grid-wrap">
                                        <figure>
                                            <a href="#">{!! $video_hot_embed[$k] !!}</a>
                                        </figure>
                                        <div class="ereaders-blog-grid-text">
                                            <h3><a href="#">{{ $v_title }}</a></h3>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
