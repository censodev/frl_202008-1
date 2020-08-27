<?php
$carts = session('cart');
$cart_total_price = session('cart_total_price');
?>
@if(!empty($carts) && count($carts))
    <div class="header-cart middle-same header-middle-color-13" id="cart-middle" style="margin-left: 0px !important;">
    <button class="icon-cart">
        <i class="fa fa-cart-arrow-down cart-bag" aria-hidden="true"></i>
        <span class="count-style">{{ (!empty($carts)) ? count($carts) : 0 }}</span>
    </button>
    <div class="shopping-cart-content shopping-cart-content-body">
        <ul>
            @if(!empty($carts) && count($carts) > 0)
                @foreach($carts as $key =>$item)
                    <li class="single-shopping-cart">
                        <div class="shopping-cart-img">
                            <a href="{{ url( $item['alias'] ) }}"><img style="width: 80px;" alt="{{ $item['alt'] }}" title="{{ $item['title'] }}" src="{{ $item['image'] }}"></a>
                        </div>
                        <div class="shopping-cart-title">
                            <h4><a href="{{ url( $item['alias'] ) }}">{{ substr($item['name'],0,18) }} ...</a></h4>
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
            <a class="btn-style btn-hover" href="{{ route('info-cart') }}">Giỏ hàng</a>
        </div>
    </div>
</div>
@endif
