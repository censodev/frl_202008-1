<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Số Liệu Thống Kê</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group">
			<label for="title_funfact">Tiêu Đề</label>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text">@</span>
			  </div>
			  <input type="text" id="title_funfact" name="title_funfact" value="{{ old('title_funfact') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  <div id="holder-funfact" class="thumbnail holder-thumbnail text-center"></div>
		  <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-funfact" data-preview="holder-funfact" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-funfact" class="form-control" type="text" name="images_funfact" readonly>
		  </div>

		  <div class="form-group mt-3">
			<label for="content_funfact">Nội Dung</label>
			<textarea id="content_funfact" name="content_funfact" class="form-control ckeditor-lfm" rows="4">{!! old('content_funfact') !!}</textarea>
		  </div>

		  <!-- Default box -->
		  <div class="card card-solid mt-3">
			<div class="card-header">
			  <h3 class="card-title">Số Liệu</h3>
			</div>
			<div class="card-body pb-0">
			  <div class="row d-flex align-items-stretch increment-funfact">

				<div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch">
				  <div class="card bg-light">
					<div class="card-header text-muted border-bottom-0">
					  Số Liệu
					</div>
					<div class="card-body pt-0">
					  <div class="form-group">
						<label for="funfact_number">Giá Trị</label>
						<input type="number" id="funfact_number" name="funfact_number[]" placeholder="Nhập số liệu" class="form-control" value="">
					  </div>

					  <div class="form-group">
						<label for="funfact_icon">Icon</label>
						<input type="text" id="funfact_icon" name="funfact_icon[]" placeholder="Nhập icon" class="form-control" value="">
					  </div>

					  <div class="form-group">
						<label for="funfact_description">Mô Tả</label>
						<textarea id="funfact_description" name="funfact_description[]" class="form-control" rows="4" placeholder="Nhập mô tả"></textarea>
					  </div>
					</div>
				  </div>
				</div>

			  </div>

			  <div class="form-group text-right">
				<button class="btn-clone-funfact btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Số Liệu</button>
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