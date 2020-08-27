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
    'category'          => $data['category']
])

@section('title')
    {{ $data->title }}
@endsection

<?php
$image_category_product = !(empty($data['category']->images)) ? $data['category']->images : asset('assets/client/dist/img/banner/banner-default.jpg');
$list_product = $data['list_product'];
$view_product = $data['viewed_product'];
$materials = $data['materials'];
?>

@section($data->content)

    @include('frontend.includes.breadcrumb')
    <div class="ereaders-main-content">
        <div class="ereaders-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ereaders-shop-filter">
                            <input type="hidden" value="{{ $data['category']->id }}" id="category_id">
                            <div class="ereaders-search-select">
                                <select name="sort_name">
                                    <option value="" selected>Tên</option>
                                    <option value="asc">A-Z</option>
                                    <option value="desc">Z-A</option>
                                </select>
                            </div>
                            <div class="ereaders-search-select">
                                <select name="sort_price">
                                    <option value="" selected>Giá</option>
                                    <option value="asc">Tăng dần</option>
                                    <option value="desc">Giảm dần</option>
                                </select>
                            </div>
                            <div class="ereaders-search-select">
                                <select name="sort_type">
                                    <option value="" selected>Loại</option>
                                    <option value="new">Mới</option>
                                    <option value="hot">Nổi Bật</option>
                                    <option value="sale">Khuyến Mại</option>
                                    <option value="selling">Bán Chạy</option>
                                </select>
                            </div>
                            <div class="ereaders-search-select">
                                <select name="sort_number">
                                    <option value="">Hiển thị</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="list-product-filter">
                        <div class="col-md-12">
                            <div class="ereaders-shop ereaders-shop-grid">
                                <ul class="row" id="product-of-category">
                                    {!! render_products($list_product) !!}
                                </ul>
                            </div>
                            <div id="pagination-product-of-category">
                                {{ $list_product->links('frontend.includes.pagination') }}
                            </div>
                        </div>
                    </div>

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
@endsection
