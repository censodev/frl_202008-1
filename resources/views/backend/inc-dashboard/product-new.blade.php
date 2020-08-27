<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Sản Phẩm Mới</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group">
			<label for="title_product_hot">Tiêu Đề</label>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text">@</span>
			  </div>
			  <input type="text" id="title_product_new" name="title_product_new" value="{{ $home_default->title_product_new ?? old('title_product_new') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  <div id="holder-product-hot" class="thumbnail holder-thumbnail text-center">
			@if( !empty( $home_default->images_product_new ) )
			  <img src="{{ $home_default->images_product_new }}" style="height: 5rem;">
			@endif
		  </div>
		  <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-product-new" data-preview="holder-product-new" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-product-new" class="form-control" type="text" name="images_product_new" value="{{ $home_default->images_product_new }}">
		  </div>

		  <div class="form-group mt-3">
			<label for="content_product_hot">Nội Dung</label>
			<textarea id="content_product_new" name="content_product_new" class="form-control ckeditor-lfm" rows="4">{!! $home_default->content_product_new ?? old('content_product_new') !!}</textarea>
		  </div>

			<div class="form-group block-search-appliesto">
			  <label for="seo_title">Chọn Sản Phẩm ( Những Sản Phẩm Mới )</label><br/>
			  <button class="btn btn-info product_search_new" type="button" data-toggle="modal" data-target="#modal-lg-product-new" search="inProductNew" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
			</div>
			<div class="form-group">
			  <ul class="todo-list appliesto-value block-product-new-list" data-widget="todo-list">

				@if( !empty( $related_products_new ) && count( $related_products_new ) > 0 )
				  @foreach( $related_products_new as $product )
					@php
					  $images = $product->images ?? asset('assets/admin/dist/img/no_image.png');
					@endphp
					<li class="ul-item-product-new {{ $product->id }}">
						<input type="hidden" name="related_product_new[]" value="{{ $product->id }}">
						<!-- drag handle -->
						<span class="handle">
						  <i class="fas fa-ellipsis-v"></i>
						  <i class="fas fa-ellipsis-v"></i>
						</span>
						<img width="40px" height="40px" src="{{ $images }}">
						<span class="text">
							<a href="">{{ $product->title }}</a>
						</span>
						<div class="tools">
							<div class="remove-item__action" itemID="{{ $product->id }}"><i class="fas fa-trash"></i></div>
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
