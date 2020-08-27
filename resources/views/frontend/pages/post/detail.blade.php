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
    'post_detail'       => $data['post_detail']
])

@section('title')
    {{ $data->title }}
@endsection

@section($data->content)
    @php
        $post_detail = $data['post_detail'];
        $category_detail = $data['category_detail'];
        $images = $post_detail->images ?? '';
        $title_image = $post_detail->title_image ?? $post_detail->title;
        $alt_image   = $post_detail->alt_image ?? $post_detail->title;

        if( !empty( $post_detail->created_at ) ) {
            $created_at = date_create($post_detail->created_at);
            $post_date  = date_format($created_at,"d/m/Y");
        }else {
            $post_date = '';
        }

        $viewed_post        = $data['viewed_post'];
        $related_posts      = $data['related_posts'];
        $related_products      = $data['related_products'];
    @endphp

    @include('frontend.includes.breadcrumb-detail-blog')

    <div class="ereaders-main-content">

        <div class="ereaders-main-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="blog-meta mb-20">
                            <ul>
                                <li>Ngày đăng: <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post_date }}</li>
                                <li>Lượt xem: <i class="fa fa-eye" aria-hidden="true"></i> {{ $post_detail->view }}</li>
                                <li>Đánh giá: <i class="fa fa-star" aria-hidden="true"></i> {{ $post_detail->rating }}</li>
                            </ul>
                        </div>
                        <div class="ereaders-rich-editor">
                            {!! $post_detail->description !!}
                        </div>

                        @include('frontend.includes.comment')

                        @if(!empty($related_posts) && count($related_posts) > 0)
                            <h3 class="ereaders-section-heading">Bài Viết Liên Quan</h3>
                            <div class="ereaders-blog ereaders-shop-grid">
                                <ul class="row">
                                    {!! render_posts($related_posts) !!}
                                </ul>
                            </div>
                        @endif

                        @if(!empty($related_products) && count($related_products) > 0)
                            <h3 class="ereaders-section-heading">Sản Phẩm Liên Quan</h3>
                            <div class="ereaders-shop ereaders-shop-grid">
                                <ul class="row">
                                    {!! render_products($related_products) !!}
                                </ul>
                            </div>
                        @endif

                        @if(!empty($viewed_post) && count($viewed_post) > 0)
                            <h3 class="ereaders-section-heading">Bài Viết Đã Xem</h3>
                            <div class="ereaders-blog ereaders-shop-grid">
                                <ul class="row">
                                    {!! render_posts($viewed_post) !!}
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
