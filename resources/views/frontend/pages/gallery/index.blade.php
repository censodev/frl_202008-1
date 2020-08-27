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

@section($data->content)
    @php
        $galleries      = $data['galleries'];

        $catCurrentIDS  = $data['catCurrentIDS'];
        $catIDS         = $data['catIDS'];
    @endphp
	
	@if( !empty( $catIDS ) && count( $catIDS ) > 0 )
	<!--Attorneys Team Layout start Here -->
	<div class="section-space30">

		@foreach ( $catIDS as $key => $gallery_cat_id )
			@php
				if( $gallery_cat_id == @$catCurrentIDS[0] ) {
					$all_gallery_child_top = AllGalleryChild( $gallery_cat_id, $catCurrentIDS );
				}else {
					$all_gallery_child_top = AllGalleryChild( $gallery_cat_id );
				}
			@endphp

			@if( !empty( $all_gallery_child_top ) && count( $all_gallery_child_top ) > 0 )
				@if( count( $catIDS ) == 1 && $all_gallery_child_top->count() == 1 )
					@php
						$redirect_single = url( $all_gallery_child_top[0]->alias );

						header("Location: {$redirect_single}");
						exit();
					@endphp
				@else
					<div class="container">
						<div class="section-title-dark">
							<h2>{{ getNameCategoryById( $gallery_cat_id ) }}</h2>
							<span><i class="fa fa-circle-o" aria-hidden="true"></i></span>
						</div>
						<div class="row">
							@if( !empty( $all_gallery_child_top ) && count( $all_gallery_child_top ) > 0 )
								@php
									$gallery_html      = render_galleries( $all_gallery_child_top, 'default' );
								@endphp

								{!! $gallery_html !!}
							@endif
						</div>
					</div>
					
				@endif
			@endif
		@endforeach

	</div>
	<!--Attorneys Team area end here  -->
	@endif

@endsection