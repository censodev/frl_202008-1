
@if (!empty($home_default->title_album_hot) || !empty($home_default->content_album_hot))
<div class="ereaders-main-section ereaders-blog-gridfull">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ereaders-fancy-title">
                    <h2 class="bounceIn wow">{{ $home_default->title_album_hot }}</h2>
                    <div class="clearfix"></div>
                    <div class="fadeInRight wow">
                        {!! $home_default->content_album_hot !!}
                    </div>
                </div>
                <div class="ereaders-blog ereaders-blog-grid fadeInUp wow">
                    <ul class="row">
                        @foreach ($album_hot_title as $k => $a_title)
                            @if ($a_title)
                                <li class="col-md-3">
                                    <div class="ereaders-blog-grid-wrap">
                                        <figure>
                                            <a class="fancybox" rel="gallery1" href="{{ $album_hot_images[$k] }}">
                                                <img src="{{ $album_hot_images[$k] }}" alt="{{ $album_hot_alt_images[$k] }}">
                                            </a>
                                        </figure>
                                        <div class="ereaders-blog-grid-text">
                                            <h3><a href="#">{{ $a_title }}</a></h3>
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
