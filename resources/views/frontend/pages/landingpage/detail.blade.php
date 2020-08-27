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
        $landingPage = $data['landingPage'];
    @endphp

    @if( $landingPage )

        @php
            $related_sliders        = $data['related_sliders'];
            $related_posts_service  = $data['related_posts_service'];
			$related_products_hot  		= $data['related_products_hot'];
			$related_products_sale  	= $data['related_products_sale'];
			$related_products_selling  	= $data['related_products_selling'];
            $related_galleries      = $data['related_galleries'];
            $related_teams          = $data['related_teams'];
            $related_posts          = $data['related_posts'];
            $related_partners       = $data['related_partners'];
            $feedbacks              = $data['feedbacks'];

			$services_url           = $data['services_url'];
            $services_description   = $data['services_description'];

            $funfact_number         = json_decode( $landingPage->funfact_number );
            $funfact_icon           = json_decode( $landingPage->funfact_icon );
            $funfact_description    = json_decode( $landingPage->funfact_description );

            $count_funfact_number = $count_funfact_description = 0;
            if( !empty( $funfact_number ) && count( $funfact_number ) > 0 ) {
                $count_funfact_number = count( $funfact_number );
            }

            if( !empty( $funfact_icon ) && count( $funfact_icon ) > 0 ) {
                $count_funfact_icon = count( $funfact_icon );
            }

            if( !empty( $funfact_description ) && count( $funfact_description ) > 0 ) {
                $count_funfact_description = count( $funfact_description );
            }

            $count_funfact = max($count_funfact_number, $count_funfact_number, $count_funfact_description);

            $count_funfact = max($count_funfact_number, $count_funfact_icon, $count_funfact_description);

            $why_title          = json_decode( $landingPage->why_title );
            $why_icon           = json_decode( $landingPage->why_icon );
            $why_description    = json_decode( $landingPage->why_description );

            $count_why_title = $count_icon_title = $count_why_description = 0;
            if( !empty( $why_title ) && count( $why_title ) > 0 ) {
                $count_why_title = count( $why_title );
            }

            if( !empty( $why_icon ) && count( $why_icon ) > 0 ) {
                $count_why_icon = count( $why_icon );
            }

            if( !empty( $why_description ) && count( $why_description ) > 0 ) {
                $count_why_description = count( $why_description );
            }

            $count_why = max($count_why_title, $count_why_icon, $count_why_description);
        @endphp

        <!-- Banner Section -->
        @include('frontend.includes.banner')
        <!-- End Banner Section -->

    	<!-- About Section -->
        @include('frontend.pages.landingpage.partial.about')
        <!--End About Section -->

        <!-- Post Services Section -->
        @include('frontend.pages.landingpage.partial.post-services')
        <!--End Post Services Section -->

        <!-- Why Section -->
        @include('frontend.pages.landingpage.partial.why')
        <!--End Why Section -->

        <!-- Counter Section -->
        @include('frontend.pages.landingpage.partial.counter')
        <!--End Counter Section -->

        <!-- Testimonial Section -->
        @include('frontend.pages.landingpage.partial.testimonial')
        <!--End Testimonial Section -->

        <!-- Partner Section -->
        @include('frontend.pages.landingpage.partial.partner')
        <!--End Partner Section -->

    @endif

@endsection
