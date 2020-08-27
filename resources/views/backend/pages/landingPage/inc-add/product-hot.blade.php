<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Sản Phẩm Nổi Bật</h3>
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
			  <input type="text" id="title_product_hot" name="title_product_hot" value="{{ old('title_product_hot') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-product-hot" data-preview="holder-product-hot" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-product-hot" class="form-control" type="text" name="images_product_hot" value="">
		  </div>

		  <div class="form-group mt-3">
			<label for="content_product_hot">Nội Dung</label>
			<textarea id="content_product_hot" name="content_product_hot" class="form-control ckeditor-lfm" rows="4">{!! old('content_product_hot') !!}</textarea>
		  </div>
		  
			<div class="form-group block-search-appliesto">
			  <label for="seo_title">Chọn Sản Phẩm ( Những Sản Nổi Bật )</label><br/>
			  <button class="btn btn-info product_search_hot" type="button" data-toggle="modal" data-target="#modal-lg-product-hot" search="inProductHot" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
			</div>
			<div class="form-group">
			  <ul class="todo-list appliesto-value block-product-hot-list" data-widget="todo-list">

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