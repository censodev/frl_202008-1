<div class="col-md-12">
    <div class="ereaders-shop ereaders-shop-grid">
        <ul class="row" id="product-of-category">
            {!! render_products($list_product) !!}
        </ul>
    </div>
    <div id="pagination-product-of-category">
        {{ $pagiante->links('frontend.includes.pagination') }}
    </div>
</div>
