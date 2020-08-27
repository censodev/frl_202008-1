@if( !empty( $home_default->title_product_selling ) || !empty( $home_default->content_product_selling ) || ( !empty( $related_products_selling ) && count( $related_products_selling ) > 0 ) )
	@if( !empty( $home_default->images_product_selling ) )
    <style type="text/css">
        .product-selling-section {
            background-image: url('{{ $home_default->images_product_selling }}');
        }
    </style>
	@endif
	@php
		$related_products_selling_html  = '';
		$related_products_selling_html = render_products( $related_products_selling, 'carousel', $contact );
	@endphp
    <div class="section-block-bg product-selling-section section-i-bg">
        <div class="container">
            <div class="section-heading center-holder">
                <h3>{{ $home_default->title_product_selling ?? '' }}</h3>
                <div class="section-heading-line"></div>
                <p>{!! $home_default->content_product_selling ?? '' !!}</p>
            </div>
            <div class="owl-carousel owl-theme mt-25 mchn-carousel-2">
				@if( !empty( $related_products_selling_html ) )
					{!! $related_products_selling_html !!}
				@endif
            </div>
        </div>
    </div>
@endif