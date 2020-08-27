@if( !empty( $home_default->title_product_hot ) || !empty( $home_default->content_product_hot ) || ( !empty( $related_products_hot ) && count( $related_products_hot ) > 0 ) )
	@if( !empty( $home_default->images_product_hot ) )
    <style type="text/css">
        .product-hot-section {
            background-image: url('{{ $home_default->images_product_hot }}');
        }
    </style>
	@endif
	@php
		$related_products_hot_html  = '';
		$related_products_hot_html = render_products( $related_products_hot, 'carousel', $contact );
	@endphp
    <div class="section-block-bg product-hot-section section-i-bg">
        <div class="container">
            <div class="section-heading center-holder">
                <h3>{{ $home_default->title_product_hot ?? '' }}</h3>
                <div class="section-heading-line"></div>
                <p>{!! $home_default->content_product_hot ?? '' !!}</p>
            </div>
            <div class="owl-carousel owl-theme mt-25 mchn-carousel-2">
				@if( !empty( $related_products_hot_html ) )
					{!! $related_products_hot_html !!}
				@endif
            </div>
        </div>
    </div>
@endif