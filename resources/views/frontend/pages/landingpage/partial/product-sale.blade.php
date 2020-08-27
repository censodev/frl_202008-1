@if( !empty( $home_default->title_product_sale ) || !empty( $home_default->content_product_sale ) || ( !empty( $related_products_sale ) && count( $related_products_sale ) > 0 ) )
	@if( !empty( $home_default->images_product_sale ) )
    <style type="text/css">
        .product-sale-section {
            background-image: url('{{ $home_default->images_product_sale }}');
        }
    </style>
	@endif
	@php
		$related_products_sale_html  = '';
		$related_products_sale_html = render_products( $related_products_sale, 'carousel', $contact );
	@endphp
    <div class="section-block-bg product-sale-section section-i-bg">
        <div class="container">
            <div class="section-heading center-holder">
                <h3>{{ $home_default->title_product_sale ?? '' }}</h3>
                <div class="section-heading-line"></div>
                <p>{!! $home_default->content_product_sale ?? '' !!}</p>
            </div>
            <div class="owl-carousel owl-theme mt-25 mchn-carousel-2">
				@if( !empty( $related_products_sale_html ) )
					{!! $related_products_sale_html !!}
				@endif
            </div>
        </div>
    </div>
@endif