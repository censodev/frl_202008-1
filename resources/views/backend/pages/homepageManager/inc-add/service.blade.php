<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Lĩnh Vực Hoạt Động</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group">
			<label for="title_service">Tiêu Đề</label>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text">@</span>
			  </div>
			  <input type="text" id="title_service" name="title_service" value="{{ old('title_service') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  <div id="holder-service" class="thumbnail holder-thumbnail text-center"></div>
		  <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-service" data-preview="holder-service" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-service" class="form-control" type="text" name="images_service">
		  </div>

		  <div class="form-group mt-3">
			<label for="content_service">Nội Dung</label>
			<textarea id="content_service" name="content_service" class="form-control ckeditor-lfm" rows="4">{!! old('content_service') !!}</textarea>
		  </div>

		  <div class="form-group block-search-appliesto mt-3">
			<label for="seo_title">Chọn Lĩnh Vực Hoạt Động ( Bài Viết )</label><br/>
			<button class="btn btn-info article_service_search" type="button" data-toggle="modal" data-target="#modal-lg-article-service" search="inArticleService" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
		  </div>
		  <div class="form-group">
			<ul class="todo-list appliesto-value block-article-service-list" data-widget="todo-list">

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