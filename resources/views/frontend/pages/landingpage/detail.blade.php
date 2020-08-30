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

                @endif
            @endforeach
        @endif

        </div>
    @endif
@endsection
