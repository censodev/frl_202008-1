<?php
use App\Models\backend\ProductItem;
?>

@extends($data->layout, [
    'title'             => $data['title'],
    "seo_title"         => $data['seo_title'],
    'og_image'          => $data['og_image'],
    'og_url'            => $data['og_url'],
    'seo_description'   => $data['seo_description'],
    'seo_keywords'      => $data['seo_keywords'],
    'product_detail'    => $data['product_detail']
])

@section('title')
    {{ $data->title }}
@endsection

@section($data->content)
    @php
        $product_detail = $data['product_detail'];
        $category = $data['category'];

        $related_products = $data['related_products'];
        $related_posts = $data['related_posts'];
        $view_product = $data['viewed_product'];

        $list_product = ProductItem::where('product_id',$product_detail->id)->get();
        $item_frist = $list_product[0];

        $material = $data['materials'];
        $list_endows = $data['list_endows'];

        $images         = json_decode( $product_detail->images );
        $title_image    = json_decode( $product_detail->title_image );
        $alt_image      = json_decode( $product_detail->alt_image );

        $footer_contact_info    = !empty( $footers->footer_contact_info ) ? json_decode( $footers->footer_contact_info ) : [];
    @endphp

    @include('frontend.includes.breadcrumb-detail')

    <div class="ereaders-main-content ereaders-content-padding">

        <div class="ereaders-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ereaders-shop-detail">
                            <div class="row">
                                <div class="col-md-6">
                                    @if($images && count($images) > 0 )
                                        <div class="ereaders-shop-thumb">
                                            @foreach( $images as $key => $item)
                                                <div class="ereaders-images-thumb-layer index-{{$key}}"><span><small>Sale</small><img src="{{ $item }}" alt="{{ $alt_image[$key] }}" title="{{ $title_image[$key] }}"></span></div>
                                            @endforeach
                                        </div>
                                        <div class="ereaders-shop-thumb-list">
                                            @foreach( $images as $key => $item)
                                                <div class="ereaders-images-list-layer"><span><img src="{{ $item }}" alt="{{ $alt_image[$key] }}" title="{{ $title_image[$key] }}"></span></div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4 area-info-product-detail">
                                    <div class="ereaders-detail-thumb-text">
                                        <h3>{{ $product_detail->title }}</h3>
                                        <div class="product-code">
                                            <h4>{{ $product_detail->code }}</h4>
                                        </div>
                                        <div class="star-rating">
                                            {!! rating_star($product_detail->rating) !!}
                                        </div>
                                        <label>
                                            <span><i class="fa fa-eye" aria-hidden="true"></i> {{ $product_detail->view }}</span>
                                            <span><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{ $product_detail->bought }}</span>
                                        </label>
                                        <div class="clearfix"></div>
                                        <span><p id="price_buy">{{ number_format($item_frist->price_promotion, 0, ".", ".") . ' đ' }}</p><del><p id="price_promotion">{{ number_format($item_frist->price_buy, 0, ".", ".") . ' đ' }}</p></del></span>
                                        {!! $product_detail->short_description !!}

                                        <div class="list-item ereaders-detail-option">
                                            @foreach($list_product as $key => $item)
                                                <div class="item" data-id-item="{{ $item->id }}">
                                                    <label>
                                                        <span>
                                                            @if($item->material)
                                                                {{ $material[$item->material] }}
                                                            @endif
                                                        </span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="ereaders-number-select">
                                            <div class="product-action product-add-to-card">
                                                <input class="cart-plus-minus-box" type="number" name="quantity" value="1" min="1" data-id="{{ $item_frist->id }}">
                                                <button>Thêm vào giỏ hàng</button>
                                                <button data-type="fast">Mua nhanh</button>
                                            </div>
                                        </div>
                                        <div class="ereaders-map-hotline">
                                            <a href="{{ route('contact').'/#google-map' }}">
                                                <img src="{{ asset('storage/files/1/Logo/chi-duong.jpg') }}">
                                            </a>
                                            <a href="tel:{{ $footer_contact_info[3] }}" target="_blank" title="Hotline">
                                                <img src="{{ asset('storage/files/1/Logo/hotline.jpg') }}">
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-2 area-related-post">
                                    @if($related_posts && count($related_posts) > 0 )
                                        <div class="widget widget_popular_post widget_border">
                                            <ul>
                                                @foreach($related_posts as $key => $post)
                                                    <li>
                                                        <img src="{{ $post->images }}" title="{{ $post->title_image }}" alt="{{ $post->alt_image }}">
                                                        <h6><a href="{{ url( $post->alias ) }}">{{ $post->title }}</a></h6>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-endow">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            @if( !empty($list_endows ) && count($list_endows) > 0)
                                <div class="ereaders-service ereaders-service-grid">
                                    <ul class="row">
                                        @foreach($list_endows as $key => $endow)
                                            <li class="col-md-4">
                                                <div class="ereaders-service-grid-text">
                                                    {!! $endow->icon !!}
                                                    <h5><a href="#">{{ $endow->name }}</a></h5>
                                                    {!! substr($endow->description,0,160) !!}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ereaders-shop-tabs">
                            <h3 class="ereaders-section-heading">Mô Tả Sản Phẩm</h3>
                            <div class="ereaders-shop-description">
                                {!! $product_detail->description !!}
                            </div>
                        </div>
                        @include('frontend.includes.comment')
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @if(!empty($related_products) && count($related_products) > 0)
                            <div class="col-md-12">
                                <div class="ereaders-shop ereaders-shop-grid">
                                    <h3 class="ereaders-section-heading">Sản Phẩm Liên Quan</h3>
                                    <ul class="row">
                                        {!! render_products($related_products) !!}
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if(!empty($related_posts) && count($related_posts) > 0)
                            <h3 class="ereaders-section-heading">Bài Viết Liên Quan</h3>
                            <div class="ereaders-blog ereaders-shop-grid">
                                <ul class="row">
                                    {!! render_posts($related_posts) !!}
                                </ul>
                            </div>
                        @endif

                        @if(!empty($view_product) && count($view_product) > 0)
                            <div class="col-md-12">
                                <div class="ereaders-shop ereaders-shop-grid">
                                    <h3 class="ereaders-section-heading">Sản Phẩm Đã Xem</h3>
                                    <ul class="row">
                                        {!! render_products($view_product) !!}
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>
    <div id="show-image-product" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <i class="fa fa-times close" aria-hidden="true"></i>

                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        @if($images && count($images) > 0 )
                            @foreach( $images as $key => $item)
                                <div class="item @if($key == 0) active @endif">
                                    <img src="{{ $item }}" alt="{{ $alt_image[$key] }}" title="{{ $title_image[$key] }}">
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </a>

                </div>

            </div>
        </div>
    </div>

@endsection
