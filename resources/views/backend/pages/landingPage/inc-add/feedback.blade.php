<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Cảm Nhận Của Khách Hàng</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group">
			<label for="title_feedback">Tiêu Đề</label>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text">@</span>
			  </div>
			  <input type="text" id="title_feedback" name="title_feedback" value="{{ old('title_feedback') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  <div class="form-group">
			<label for="content_feedback">Mô Tả</label>
			<textarea id="content_feedback" name="content_feedback" class="form-control ckeditor-lfm" rows="4">{!! old('content_feedback') !!}</textarea>
		  </div>

		  <div id="holder-feedback" class="thumbnail holder-thumbnail text-center"></div>
		  <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-feedback" data-preview="holder-feedback" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-feedback" class="form-control" type="text" name="images_feedback" readonly>
		  </div>

		</div>
		<!-- /.card-body -->
	  </div>
	  <!-- /.card -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->