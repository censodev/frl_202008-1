<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Tin Tức Nổi Bật</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group">
			<label for="title_news">Tiêu Đề</label>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text">@</span>
			  </div>
			  <input type="text" id="title_news" name="title_news" value="{{ $landingPage->title_news ?? old('title_news') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  <div id="holder-news" class="thumbnail holder-thumbnail text-center">
			@if( !empty( $landingPage->images_feedback ) )
			  <img src="{{ $landingPage->images_feedback }}" style="height: 5rem;">
			@endif
		  </div>
		  <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-news" data-preview="holder-news" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-news" class="form-control" type="text" name="images_news" value="{{ $landingPage->images_feedback }}" readonly>
		  </div>

		  <div class="form-group block-search-appliesto mt-3">
			<label for="seo_title">Chọn Bài Viết Nổi Bật </label><br/>
			<button class="btn btn-info article_search" type="button" data-toggle="modal" data-target="#modal-lg-article" search="inArticle" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
		  </div>
		  <div class="form-group">
			<ul class="todo-list appliesto-value block-article-list" data-widget="todo-list">

			  @if( !empty( $related_posts ) && count( $related_posts ) > 0 )
				@foreach( $related_posts as $post )
				  @php
					$images = $post->images ?? asset('assets/admin/dist/img/no_image.png');
				  @endphp
				  <li class="ul-item {{ $post->id }}">
					  <input type="hidden" name="related_post[]" value="{{ $post->id }}">
					  <!-- drag handle -->
					  <span class="handle">
						<i class="fas fa-ellipsis-v"></i>
						<i class="fas fa-ellipsis-v"></i>
					  </span>
					  <img width="40px" height="40px" src="{{ $images }}">
					  <span class="text">
						  <a href="">{{ $post->title }}</a>
					  </span>
					  <div class="tools">
						  <div class="remove-item__action" itemID="{{ $post->id }}"><i class="fas fa-trash"></i></div>
					  </div>
				  </li>
				@endforeach
			  @endif

			</ul>
		  </div>

		</div>
		<!-- /.card-body -->
	  </div>
	  <!-- /.card -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->
