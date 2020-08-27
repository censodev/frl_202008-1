@php
    $logo_top       = $logo->top->images ?? asset('assets/client/dist/images/logo-2.png');
    $title_image    = $logo->top->title_image ?? 'Logo Header';
    $alt_image      = $logo->top->alt_image ?? 'Logo Header';

	$route_search = route('search_all');
    $carts = session('cart');
    $cart_total_price = session('cart_total_price');
    $session_agency = session('data_agency');
@endphp

<header id="ereaders-header" class="ereaders-header-one">
    <div class="ereaders-main-header">
        <div class="container">
            <div class="row">
                <aside class="col-md-2">
                    <a href="{{Request::root()}}" title="{{ $title_image }}">
                        <img src="{{ $logo_top }}" alt="{{ $alt_image }}" title="{{ $title_image }}">
                    </a>
                </aside>

                <aside class="col-md-10 header-right">
                    <a href="#menu" class="menu-link active"><span></span></a>
                    <nav id="menu" class="menu navbar navbar-default">
                        <ul class="level-1 navbar-nav">
                            <li><a href="/" title="Trang chủ">Trang chủ</a></li>
                            @foreach ($categories as $category)
                                @if ($category->parent_id== -1)
                                    @if( @$category['childrens'] )
                                        @if($category->type == 5)
                                            <li class="product">
                                                <a href="{{ asset( change_cat_url_by_article_url( $category ) ) }}" title="{{ $category['title'] }}">{{ $category['title'] }}</a>
                                                <span class="has-subnav"><i class="fa fa-angle-down"></i></span>
                                                {!! gen_html_dropdown_submenu($category['childrens']) !!}
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ asset( change_cat_url_by_article_url( $category ) ) }}" title="{{ $category['title'] }}">{{ $category['title'] }}</a>
                                                <span class="has-subnav"><i class="fa fa-angle-down"></i></span>
                                                {!! gen_html_dropdown_submenu($category['childrens']) !!}
                                            </li>
                                        @endif
                                    @else
                                        <li>
                                            <a href="{{ asset( change_cat_url_by_article_url( $category ) ) }}" title="{{ $category['title'] }}">{{ $category['title'] }}</a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach
{{--                            <li class="search-box">--}}
{{--                                <a href="#"><i class="fa fa-search" aria-hidden="true"></i></a>--}}
{{--                            </li>--}}
                        </ul>
                    </nav>
                    <div class="header-cart-one header-cart middle-same header-middle-color-13">
                        <button class="icon-cart">
                            <i class="fa fa-cart-arrow-down cart-bag" aria-hidden="true"></i>
                            <span class="count-amount">{{ number_format($cart_total_price, 0,".", ".") }} đ</span>
                            <i class="fa fa-chevron-down cart-down" aria-hidden="true"></i>
                            <span class="count-style">{{ (!empty($carts)) ? count($carts) : 0 }}</span>
                        </button>
                        <div class="shopping-cart-content">
                            <ul>
                                @if(!empty($carts) && count($carts) > 0)
                                    @foreach($carts as $key =>$item)
                                        <li class="single-shopping-cart">
                                            <div class="shopping-cart-img">
                                                <a href="{{ url( $item['alias'] ) }}" title="{{ $item['title'] }}"><img style="width: 80px;" alt="{{ $item['alt'] }}" title="{{ $item['title'] }}" src="{{ $item['image'] }}"></a>
                                            </div>
                                            <div class="shopping-cart-title">
                                                <h4><a href="{{ url( $item['alias'] ) }}" title="{{ $item['name'] }}">{{ substr($item['name'],0,18) }} ...</a></h4>
                                                <h6>Số lượng : {{ $item['quantity'] }}</h6>
                                                <span>{{ number_format($item['total'], 0, ".", ".") }} đ</span>
                                            </div>
                                            <div class="shopping-cart-delete">
                                                <a href="#" data-id="{{ $item['id'] }}"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <div class="shopping-cart-total">
                                <h4>Tổng tiền : <span class="shop-total">{{ number_format($cart_total_price, 0, ".", ".") }} đ</span></h4>
                            </div>
                            <div class="shopping-cart-btn">
                                <a class="btn-style btn-hover" href="{{ route('info-cart') }}" title="Giỏ hàng">Giỏ hàng</a>
                            </div>
                        </div>
                    </div>

                    <div class="search-header-form">
                        <form action="{{ route('search_all') }}" method="GET">
                            <div class="form-group">
                                <input type="search" class="input-search" name="query" value="" placeholder="Tìm Kiếm" required>
                                <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</header>
