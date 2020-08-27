@extends($data->layout, [
    'title'             => $data['title'],
    "seo_title"         => $data['seo_title'],
    'og_image'          => $data['og_image'],
    'og_url'            => $data['og_url'],
    'seo_description'   => $data['seo_description'],
    'seo_keywords'      => $data['seo_keywords']
])

@section('title')
    {{ $data->title }}
@endsection

@section($data->content)

    @php
        $home_default = $data['home_default'];
    @endphp

    @if( $home_default )

        @php
            $related_sliders              = $data['related_sliders'];
            $related_partners              = $data['related_partners'];
            $related_hots              = $data['related_hots'];
            $related_products_hot       = $data['related_products_hot'];
            $related_hot2s              = $data['related_hot2s'];
            $related_posts              = $data['related_posts'];
            $related_endows              = $data['related_endows'];
            $related_certifies              = $data['related_certifies'];

            $related_tvs                    = $data['related_tvs'];
            $related_newspapers                    = $data['related_newspapers'];
            $feedbacks                    = $data['feedbacks'];

            $funfact_number         = json_decode( $home_default->funfact_number );
            $funfact_icon         = json_decode( $home_default->funfact_icon );
            $funfact_description    = json_decode( $home_default->funfact_description );

            $services_name         = json_decode( $home_default->services_name );
            $services_url         = json_decode( $home_default->services_url );
            $services_description    = json_decode( $home_default->services_description );

        @endphp

        <!-- Slider Section -->
        @include('frontend.pages.home.partial.slider')
        <!-- End Slider Section -->

        <div class="ereaders-main-content ereaders-content-padding">

            <!-- counter Section -->
            @include('frontend.pages.home.partial.counter')
            <!-- End counter Section -->

            <!-- danh mục nổi bật Section -->
            @include('frontend.pages.home.partial.category-hot')
            <!-- End danh mục nổi bật Section -->

            <!-- danh mục nổi bật Section -->
            @include('frontend.pages.home.partial.category-hot-2')
            <!-- End danh mục nổi bật Section -->

            <!-- danh mục nổi bật Section -->
            @include('frontend.pages.home.partial.product-hot')
            <!-- End danh mục nổi bật Section -->

            <!-- danh mục nổi bật Section -->
            @include('frontend.pages.home.partial.post-hot')
            <!-- End danh mục nổi bật Section -->

            <!-- endow Section -->
            @include('frontend.pages.home.partial.endow')
            <!-- End endow Section -->

            <!-- dịch vụ Section -->
            @include('frontend.pages.home.partial.service')
            <!-- End dịch vụ Section -->

            <!-- chứng nhận Section -->
            @include('frontend.pages.home.partial.certify')
            <!-- End chứng nhận Section -->

            <!-- dịch vụ Section -->
            @include('frontend.pages.home.partial.tv-new')
            <!-- End dịch vụ Section -->

            <!-- Cảm Nhận Section -->
            @include('frontend.pages.home.partial.feedback')
            <!-- End cảm nhận Section -->

            <!-- đối tác Section -->
            @include('frontend.pages.home.partial.partner')
            <!-- End đối tác Section -->


        </div>


    @endif

@endsection
