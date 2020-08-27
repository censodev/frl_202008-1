<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Giới Thiệu</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group">
			<label for="title_about">Tiêu Đề</label>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text">@</span>
			  </div>
			  <input type="text" id="title_about" name="title_about" value="{{ $homepageManager->title_about ?? old('title_about') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  <div id="holder-about" class="thumbnail holder-thumbnail text-center">
			@if( !empty( $homepageManager->images_about ) )
			  <img src="{{ $homepageManager->images_about }}" style="height: 5rem;">
			@endif
		  </div>
		  <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-about" data-preview="holder-about" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Hình Ảnh
			  </a>
			</span>
			<input id="thumbnail-about" class="form-control" type="text" name="images_about" value="{{ $homepageManager->images_about }}">
		  </div>

		  <div class="row mt-3">
			<div class="col-md-6">
			  <div class="form-group">
				<label for="title_image_about">Tiêu Đề Hình Ảnh</label>
				<input type="text" id="title_image_about" name="title_image_about" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ $homepageManager->title_image_about ?? old('title_image_about') }}">
			  </div>
			</div>

			<div class="col-md-6">
			  <div class="form-group">
				<label for="alt_image_about">Mô Tả Hình Ảnh</label>
				<input type="text" id="alt_image_about" name="alt_image_about" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ $homepageManager->alt_image_about ?? old('alt_image_about') }}">
			  </div>
			</div>
		  </div>

		  <div class="form-group">
			<label for="content_about">Nội Dung</label>
			<textarea id="content_about" name="content_about" class="form-control ckeditor-lfm" rows="4">{!! $homepageManager->content_about ?? old('content_about') !!}</textarea>
		  </div>

		  <div class="row mt-3">
			<div class="col-md-6">
			  <div class="form-group">
				<label for="title_button_about">Button Tiêu Đề</label>
				<input type="text" id="title_button_about" name="title_button_about" placeholder="Nhập button tiêu đề" class="form-control" value="{{ $homepageManager->title_button_about ?? old('title_button_about') }}">
			  </div>
			</div>

			<div class="col-md-6">
			  <div class="form-group">
				<label for="button_link_about">Button Đường Dẫn</label>
				<input type="text" id="button_link_about" name="button_link_about" placeholder="Nhập button đường dẫn" class="form-control" value="{{ $homepageManager->button_link_about ?? old('button_link_about') }}">
			  </div>
			</div>
		  </div>

		</div>
		<!-- /.card-body -->
	  </div>
	  <!-- /.card -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->