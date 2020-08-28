@if( !empty( $home_default->title_product_sale ) || !empty( $home_default->content_product_sale ) || ( !empty( $related_products_sale ) && count( $related_products_sale ) > 0 ) )
    <div class="ereaders-main-section ereaders-product-gridfull">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ereaders-fancy-title">
                        <h2 class="bounceIn wow">{{ $home_default->title_product_sale }}</h2>
                        <div class="clearfix"></div>
                        <div class="fadeInRight wow">
                            {!! $home_default->content_product_sale !!}
                        </div>
                    </div>
                    <div class="ereaders-shop ereaders-shop-grid fadeInUp wow">
                        <ul class="row" id="product-of-category">
                            {!! render_products($related_products_sale) !!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
