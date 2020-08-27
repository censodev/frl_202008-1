<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Sản Phẩm Khuyến Mãi</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group">
			<label for="title_product_sale">Tiêu Đề</label>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text">@</span>
			  </div>
			  <input type="text" id="title_product_sale" name="title_product_sale" value="{{ $homepageManager->title_product_sale ?? old('title_product_sale') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  <div id="holder-product-sale" class="thumbnail holder-thumbnail text-center">
			@if( !empty( $homepageManager->images_product_sale ) )
			  <img src="{{ $homepageManager->images_product_sale }}" style="height: 5rem;">
			@endif
		  </div>
		  <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-product-sale" data-preview="holder-product-sale" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-product-sale" class="form-control" type="text" name="images_product_sale" value="{{ $homepageManager->images_product_sale }}">
		  </div>

		  <div class="form-group mt-3">
			<label for="content_product_sale">Nội Dung</label>
			<textarea id="content_product_sale" name="content_product_sale" class="form-control ckeditor-lfm" rows="4">{!! $homepageManager->content_product_sale ?? old('content_product_sale') !!}</textarea>
		  </div>
		  
			<div class="form-group block-search-appliesto">
			  <label for="seo_title">Chọn Sản Phẩm ( Những Sản Khuyến Mãi )</label><br/>
			  <button class="btn btn-info product_search_sale" type="button" data-toggle="modal" data-target="#modal-lg-product-sale" search="inProductSale" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
			</div>
			<div class="form-group">
			  <ul class="todo-list appliesto-value block-product-sale-list" data-widget="todo-list">

				@if( !empty( $related_products_sale ) && count( $related_products_sale ) > 0 )
				  @foreach( $related_products_sale as $product )
					@php
					  $images = $product->images ?? asset('assets/admin/dist/img/no_image.png');
					@endphp
					<li class="ul-item-product-sale {{ $product->id }}">
						<input type="hidden" name="related_product_sale[]" value="{{ $product->id }}">
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