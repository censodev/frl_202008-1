@php
    use App\Models\backend\Slider;
    use App\Models\backend\Product;
    use App\Models\backend\Post;
    use App\Models\backend\Newspaper;
    use App\Models\backend\Tv;
    use App\Models\backend\Endow;
@endphp
@extends($data->layout, [
    'title'             => $data['title'],
    "seo_title"         => $data['seo_title'],
    'og_image'          => $data['og_image'],
    'og_url'            => $data['og_url'],
    'seo_description'   => $data['seo_description'],
    'seo_keywords'      => $data['seo_keywords']
])

@section('title')
    {{ $data->title }}
@endsection

@section($data->content)
    @php
        $landingPage = $data['landingPage'];
    @endphp

    @if( $landingPage )
        @php
            $sections = $data['sections'];
        @endphp

        @include('frontend.pages.home.partial.slider')
        <div class="ereaders-main-content ereaders-content-padding">

        @if(!empty($sections) && count($sections) > 0)
            @foreach($sections as $key => $section)
                @php
                    $type = $section->type;
                    $Ids = $listItems = [];
                    $Ids = json_decode($section->items,true);
                @endphp
                @if(isset($section->items) && !empty($section->items))

                    @if($type == 'article')
                        @php
                            $listItems              = Post::whereIn('id', $Ids)->where('status',1)->get();
                        @endphp
                        <div class="ereaders-main-section ereaders-blog-gridfull">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ereaders-fancy-title">
                                            <h2 class="bounceIn wow">{{ $section->name }}</h2>
                                            <div class="clearfix"></div>
                                            <div class="fadeInRight wow">
                                                {!! $section->description !!}
                                            </div>
                                        </div>
                                        <div class="ereaders-blog ereaders-blog-grid fadeInUp wow">
                                            <ul class="row">
                                                @if(!empty($listItems) && count($listItems) > 0)
                                                    {!! render_posts($listItems) !!}
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($type == 'product')
                        @php
                            $listItems              = Product::whereIn('id', $Ids)->where('status',1)->get();
                        @endphp
                        <div class="ereaders-main-section ereaders-hot-product">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ereaders-fancy-title">
                                            <h2 class="bounceIn wow">{{ $section->name }}</h2>
                                            <div class="clearfix"></div>
                                            <div class="fadeInRight wow">
                                                {!! $section->description !!}
                                            </div>
                                        </div>
                                        <div class="ereaders-shop ereaders-shop-grid fadeInUp wow">
                                            <ul class="row" id="product-of-category">
                                                @if(!empty($listItems) && count($listItems) > 0)
                                                    {!! render_products($listItems) !!}
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($type == 'slider')
                        @php
                            $listItems              = Slider::whereIn('id', $Ids)->where('status',1)->get();
                        @endphp
                    @endif

                    @if($type == 'newspaper')
                        @php
                            $listItems              = Newspaper::whereIn('id', $Ids)->where('status',1)->get();
                        @endphp


                    @endif

                    @if($type == 'tv')
                        @php
                            $listItems              = Tv::whereIn('id', $Ids)->where('status',1)->get();
                        @endphp
                    @endif

                    @if($type == 'endow')
                        @php
                            $listItems              = Endow::whereIn('id', $Ids)->where('status',1)->get();
                        @endphp
                        <div class="ereaders-main-section ereaders-service-gridfull">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ereaders-fancy-title">
                                            <h2 class="bounceIn wow">{{ $section->name }}</h2>
                                            <div class="clearfix"></div>
                                            <div class="fadeInRight wow">
                                                {!! $section->description !!}
                                            </div>
                                        </div>
                                        <div class="ereaders-service ereaders-service-grid fadeInUp wow">
                                            <ul class="row">
                                                @if(!empty($listItems) && count($listItems) > 0)
                                                    @foreach($listItems as $key => $item)
                                                        <li class="col-md-4">
                                                            <div class="ereaders-service-grid-text">
                                                                {!! $item->icon !!}
                                                                <h5><a href="#">{{ $item->name }}</a></h5>
                                                                {!! substr($item->description,0,160) !!}
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

                    @if($type == 'service')
                        @php
                            $listItems = json_decode($section->items, true);
                        @endphp
                        <div class="ereaders-main-section ereaders-service-providefull">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ereaders-fancy-title">
                                            <h2 class="bounceIn wow">{{ $section->name }}</h2>
                                            <div class="clearfix"></div>
                                            <div class="fadeInRight wow">
                                                {!! $section->description !!}
                                            </div>
                                        </div>
                                    </div>
                                    <aside class="col-md-12">
                                        <div class="ereaders-service ereaders-service-list fadeInUp wow">
                                            <ul class="row">
                                                @if(!empty($listItems['services_name']) && count($listItems['services_name']) > 0)
                                                    @foreach($listItems['services_name'] as $key => $item)
                                                        @if($item != null)
                                                            <li class="col-md-4">
                                                                {!! $listItems['services_url'][$key] !!}
                                                                <h5><a href="#">{{ $item }}</a></h5>
                                                                {!! substr($listItems['services_description'][$key], 0, 150) !!}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($type == 'video-hot')
                        @php
                            $listItems = json_decode($section->items, true);
                        @endphp
                        <div class="ereaders-main-section ereaders-blog-gridfull">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ereaders-fancy-title">
                                            <h2 class="bounceIn wow">{{ $section->name }}</h2>
                                            <div class="clearfix"></div>
                                            <div class="fadeInRight wow">
                                                {!! $section->description !!}
                                            </div>
                                        </div>
                                        <div class="ereaders-blog ereaders-blog-grid fadeInUp wow">
                                            <ul class="row">
                                                @foreach ($listItems['video_hot_title'] as $k => $v_title)
                                                    @if ($v_title)
                                                        <li class="col-md-4">
                                                            <div class="ereaders-blog-grid-wrap">
                                                                <figure>
                                                                    <a href="#">{!! $listItems['video_hot_embed'][$k] !!}</a>
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

                    @if ($type == 'album-hot')
                        @php
                            $listItems = json_decode($section->items, true);
                        @endphp
                        <div class="ereaders-main-section ereaders-blog-gridfull">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ereaders-fancy-title">
                                            <h2 class="bounceIn wow">{{ $section->name }}</h2>
                                            <div class="clearfix"></div>
                                            <div class="fadeInRight wow">
                                                {!! $section->description !!}
                                            </div>
                                        </div>
                                        <div class="ereaders-blog ereaders-blog-grid fadeInUp wow">
                                            <ul class="row">
                                                @foreach ($listItems['album_hot_title'] as $k => $a_title)
                                                    @if ($a_title)
                                                        <li class="col-md-3">
                                                            <div class="ereaders-blog-grid-wrap">
                                                                <figure>
                                                                    <a class="fancybox" rel="gallery1" href="{{ $listItems['album_hot_images'][$k] }}">
                                                                        <img src="{{ $listItems['album_hot_images'][$k] }}" alt="{{ $listItems['album_hot_alt_images'][$k] }}">
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
                @endif
                @if ($type == 'feedback')
                    <div class="ereaders-main-section ereaders-testimonialfull">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ereaders-testimonial">
                                        <div class="ereaders-testimonial-wrap">
                                            @php
                                                $feedbacks = \App\Models\backend\Feedback::listFeedback();
                                            @endphp
                                            <div class="ereaders-fancy-title bounceIn wow"><h2>{{ $section->name }}</h2></div>
                                            <div class="ereaders-testimonial-slide fadeInUp wow">
                                                @if( !empty( $feedbacks ) && count( $feedbacks ) > 0 )
                                                    @foreach( $feedbacks as $feedback )
                                                        @php
                                                            $images = !empty( $feedback->images ) ? $feedback->images : asset('assets/admin/dist/img/avatar5.png');
                                                        @endphp
                                                        <div class="ereaders-testimonial-slide-layer">
                                                            <figure><img src="{{ $images }}" title="{{ $feedback->title_image }}" alt="{{ $feedback->alt_image }}"></figure>
                                                            <div class="ereaders-testimonial-text">
                                                                <h4>{{ $feedback->name_customer }}</h4>
                                                                <span>{{ $feedback->position }}</span>
                                                                {!! $feedback->description !!}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($type == 'about')
                    @php
                        $home_default = \App\Models\backend\HomepageManager::getHomeDefault();
                    @endphp
                    <div class="ereaders-main-section ereaders-product-gridfull" style="background:#fff">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ereaders-fancy-title" style="margin-bottom:30px">
                                        <h2 class="bounceIn wow">
                                            {{ $home_default->title_about }}
                                        </h2>
                                    </div>
                                    <div class="ereaders-shop ereaders-shop-grid fadeInUp wow">
                                        <div class="row d-flex" style="{{ $home_default->position_about == 1 ? 'flex-direction: row-reverse;' : '' }}">
                                            <div class="col-md-6 col-sm-12">
                                                {!! $home_default->content_about !!}
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                @if ($home_default->images_about)
                                                    <img class="w-100" src="{{ $home_default->images_about }}"
                                                        alt="{{ $home_default->alt_image_about }}" 
                                                        title="{{ $home_default->title_image_about }}">
                                                @else
                                                    {!! $home_default->video_embed_about !!}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        </div>
    @endif
@endsection
