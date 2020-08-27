@php
    $image_bg = $title = $description = '';
    $image_bg_default = asset('assets/client/dist/img/banner/inner-page-banner.jpg');
@endphp

@if( !empty( $category ) )
    @php
        $image_bg       = $category->images ?? $image_bg_default;
        $title          = $category->title ?? '';
        $description    = $category->description ?? '';
    @endphp
@elseif( !empty( $post_detail ) )
    @php
        $image_bg       = $data['category_detail']->images ?? $image_bg_default;
        $title          = $post_detail->title ?? '';
        $description    = $post_detail->seo_desciption ?? '';
    @endphp
@elseif( !empty( $gallery_detail ) )
    @php
        $image_bg       = $gallery_detail->Category->images ?? $image_bg_default;
        $title          = $gallery_detail->title ?? '';
        $description    = $gallery_detail->seo_desciption ?? '';
    @endphp
@elseif( !empty( $product_detail ) )
    @php
        $image_bg       = $product_detail->Category->images ?? $image_bg_defaul;
        $title          = $product_detail->title ?? '';
        $description    = $product_detail->seo_desciption ?? '';
    @endphp
@elseif( Route::getCurrentRoute()->getName() == 'contact' )
    @php
        $image_bg       = $contact->images_background ?? $image_bg_default;
        $title          = 'Liên Lạc';
        $description    = '';
    @endphp
@elseif( Route::getCurrentRoute()->getName() == 'search_all' )
    @php
        $image_bg       = $image_bg_default;
        $title          = 'Kết Quả Tìm Kiếm: ' . @$query;
        $description    = '';
    @endphp
@else
    @php
        $image_bg       = $image_bg_default;
    @endphp
@endif
<!-- Inner Page Banner Area Start Here -->
<section class="inner-page-banner-area mt-150" style="background-image: url('{{ $image_bg }}');">
	<div class="container">
		<div class="breadcrumbs-area">
			<h1>{{ $title }}</h1>
			<ul>
				<li><a href="{{ url('/') }}">Trang Chủ</a> //</li>
				@if( !empty( $post_detail ) )
					@if( !empty( $post_detail->getCategoryAttribute() ) )
						<li class="breadcrumb-item"><a href="{{ $post_detail->getCategoryAliasAttribute() ?? '#'}}">{{ $post_detail->getCategoryAttribute() }}</a> //</li>
					@endif
				@endif
				@if( !empty( $gallery_detail ) )
					@if( !empty( $gallery_detail->Category->title ) )
						<li class="breadcrumb-item"><a href="{{ $gallery_detail->getCategoryAliasAttribute() ?? '#'}}">{{ $gallery_detail->Category->title }}</a> //</li>
					@endif
				@endif
				@if( !empty( $product_detail ) )
					@if( !empty( $product_detail->getCategoryAttribute() ) )
						<li class="breadcrumb-item"><a href="{{ $product_detail->getCategoryAliasAttribute() ?? '#'}}">{{ $product_detail->getCategoryAttribute() }}</a> //</li>
					@endif
				@endif
				<li>{{ $title }}</li>
			</ul>
		</div>
	</div>
</section>
<!-- Inner Page Banner Area End Here -->
