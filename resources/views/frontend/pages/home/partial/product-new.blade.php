@php
    use App\Models\backend\ProductItem;
@endphp

@if( !empty( $home_default->title_product_new ) || !empty( $home_default->content_product_new ) || ( !empty( $related_products_new ) && count( $related_products_new ) > 0 ) )
    <div class="product-area pt-30 pb-45">
    <div class="container">
        <div class="section-border mb-10">
            <h1 class="section-title section-bg-white">{{ $home_default->title_product_new }}</h1>
        </div>
        <div class="product-slider-nav nav-style nav-style-persiangreen"></div>
        <div class="headphone-slider-active owl-carousel product-slider">
            @foreach($related_products_new as $key => $item)
                @php
                    $images        = json_decode( $item->image );
                    $title_images  = json_decode( $item->title_image );
                    $alt_images    = json_decode( $item->alt_image );
                    $add_to_cart = route('add-to-cart',[$item->id]);
                @endphp
                <div class="devita-product-2 devita-product-persiangreen">
                <div class="product-img">
                    <a href="{{ url( $item->alias ) }}" title="{{ url( $item->alias ) }}">
                        <img src="{{ $images[0] }}">
                    </a>
                    <span>Mới #{{ $key+1 }}</span>
                </div>
                <div class="list-col">
                    <div class="gridview">
                        <div class="product-content text-center">
                            <h4><a href="{{ url( $item->alias ) }}" title="{{ url( $item->alias ) }}">{{ $item->title }}</a></h4>
                            <div class="product-price-wrapper">
                                <span>{{ number_format($item->price_promotion) }} đ</span>
                                <span class="product-price-old">{{ number_format($item->price_buy) }} đ</span>
                            </div>
                            <div class="product-price-wrapper">
                                <span><i class="fa fa-eye" aria-hidden="true"></i> {{ $item->view }}</span>
                                <span><i class="fa fa-shopping-cart" aria-hidden="true"></i> {{ $item->bought }}</span>
                            </div>
                        </div>
                        <div class="product-action-wrapper-2 text-center">
                            <div class="product-rating">
                                {!! rating_star($item->rating) !!}
                            </div>
                            {!! Str::limit($item->short_description, 100, ' ...') !!}
                            @if((int)$item->quantity > 0)
                                <div class="product-action product-add-to-card">
                                    <input class="cart-plus-minus-box" type="number" name="quantity" value="1" min="1" data-id="{{ $item->id }}">
                                    <button type="submit">Thêm vào giỏ hàng</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
