@extends($data->layout, [
    'title'             => $data['title'],
    "seo_title"         => $data['seo_title'],
    'og_image'          => $data['og_image'],
    'og_url'            => $data['og_url'],
    'seo_description'   => $data['seo_description'],
    'seo_keywords'      => $data['seo_keywords'],
    'gallery_detail'    => $data['gallery_detail']
])

@section('title')
    {{ $data->title }}
@endsection

@section($data->content)
    @php
        $gallery_detail     = $data['gallery_detail'];

        $images             = !empty( $gallery_detail->images ) ? json_decode( $gallery_detail->images ) : [];
        $title_image        = !empty( $gallery_detail->title_image ) ? json_decode( $gallery_detail->title_image ) : [];
        $alt_image          = !empty( $gallery_detail->alt_image ) ? json_decode( $gallery_detail->alt_image ) : [];
        $videos             = !empty( $gallery_detail->videos ) ? json_decode( $gallery_detail->videos ) : [];

        $related_posts      = $data['related_posts'];
        $related_gallerys   = $data['related_gallerys'];

        $related_posts_html      = render_posts( $related_posts, 'default' );
        $related_gallerys_html   = render_galleries( $related_gallerys, 'default' );
    @endphp
	<!--Project Detail Section-->
    <div class="section-block-grey">
        <div class="container">
            <div class="project-detail">
                <div class="auto-container">
                    @if( !empty( $images ) && count( $images ) > 0 )
                        <!--MixitUp Galery-->
                        <div class="mixitup-gallery">
                            <div class="filter-list row">
                                @foreach( $images as $key => $image )
                                    <!-- Project Block -->
                                    <div class="project-block all mix col-lg-4 col-md-6 col-sm-12">
                                        <div class="image-box">
                                            <figure class="image">
                                                <img src="{{ $image }}" title="{{ $title_image[$key] ?? $gallery_detail->title }}" alt="{{ $alt_image[$key] ?? $gallery_detail->title }}">
                                            </figure>
                                            <div class="overlay-box">
                                                <h4><a href="#">{{ $title_image[$key] ?? $gallery_detail->title }}</a></h4>
                                                <div class="btn-box">
                                                    <a href="{{ $image }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if( !empty( $videos ) && count( $videos ) > 0 )
                        <!--MixitUp Galery-->
                        <div class="mixitup-gallery">
                            <div class="filter-list row">
                                @foreach( $videos as $key => $video )
                                    <!-- Project Block -->
                                    <div class="project-block all mix col-lg-4 col-md-6 col-sm-12">
                                        <div class="image-box">
                                            <figure class="image">
                                                {!! $video !!}
                                            </figure>
                                            <div class="overlay-box">
                                                <h4><a href="#">Video</a></h4>
                                                <div class="btn-box">
                                                    <a href="{{ $video }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!--Lower Content-->
                    <div class="lower-content">
                        <div class="row clearfix">
                            <!--Content Column-->
                            <div class="content-column col-lg-12 col-md-12 col-sm-12">
                                <div class="inner-column">
                                    @if( $gallery_detail->sapo )
                                        <div class="text-sapo">{!! $gallery_detail->sapo !!}</div>
                                    @endif

                                    {!! $gallery_detail->description !!}
                                </div>
                            </div>
                            <!--End Content Column-->
                        </div>
                    </div>

                    @if( !empty( $related_posts_html ) )
                        <div class="auto-container">
                            <div class="sec-title">
                                <span class="float-text">Blog</span>
                                <h2>Bài viết liên quan</h2>
                            </div>
                            <div class="row">
                                {!! $related_posts_html !!}
                            </div>
                        </div>
                    @endif

                    @if( !empty( $related_gallerys_html ) )
                        <div class="auto-container">
                            <div class="sec-title">
                                <span class="float-text">Gallery</span>
                                <h2>Bộ sưu tập liên quan</h2>
                            </div>
                            <div class="row">
                                {!! $related_gallerys_html !!}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!--End Portfolio Details-->

@endsection