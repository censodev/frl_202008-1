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

@php
    $list_landing = $data['list_landing'];
@endphp

@section($data->content)

    @include('frontend.includes.breadcrumb')
    <div class="ereaders-main-content">
        <div class="ereaders-main-section">
            <div class="container">
                <div class="row">
                    <div class="list-product-filter">
                        <div class="col-md-12">
                            <div class="ereaders-shop ereaders-shop-grid">
                                <ul class="row" id="product-of-category">
                                    {!! render_landing($list_landing) !!}
                                </ul>
                            </div>
                            <div id="pagination-product-of-category">
                                {{ $list_landing->links('frontend.includes.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
