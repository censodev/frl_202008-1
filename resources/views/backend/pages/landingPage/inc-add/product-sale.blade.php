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
			  <input type="text" id="title_product_sale" name="title_product_sale" value="{{ old('title_product_sale') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-product-sale" data-preview="holder-product-sale" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-product-sale" class="form-control" type="text" name="images_product_sale" value="">
		  </div>

		  <div class="form-group mt-3">
			<label for="content_product_sale">Nội Dung</label>
			<textarea id="content_product_sale" name="content_product_sale" class="form-control ckeditor-lfm" rows="4">{!! old('content_product_sale') !!}</textarea>
		  </div>
		  
			<div class="form-group block-search-appliesto">
			  <label for="seo_title">Chọn Sản Phẩm ( Những Sản Khuyến Mãi )</label><br/>
			  <button class="btn btn-info product_search_sale" type="button" data-toggle="modal" data-target="#modal-lg-product-sale" search="inProductSale" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
			</div>
			<div class="form-group">
			  <ul class="todo-list appliesto-value block-product-sale-list" data-widget="todo-list">

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