<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Album Ảnh Nổi Bật</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group">
			<label for="title_album_hot">Tiêu Đề</label>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text">@</span>
			  </div>
			  <input type="text" id="title_album_hot" name="title_album_hot" value="{{ $home_default->title_album_hot ?? old('title_album_hot') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  {{-- <div id="holder-album-hot" class="thumbnail holder-thumbnail text-center">
			@if( !empty( $home_default->images_album-hot ) )
			  <img src="{{ $home_default->images_album-hot }}" style="height: 5rem;">
			@endif
		  </div> --}}
		  {{-- <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-album-hot" data-preview="holder-album-hot" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-album-hot" class="form-control" type="text" name="images_album-hot" value="{{ $home_default->images_album-hot }}">
		  </div> --}}

		  <div class="form-group mt-3">
			<label for="content_album_hot">Nội Dung</label>
			<textarea id="content_album_hot" name="content_album_hot" class="form-control ckeditor-lfm" rows="4">{!! $home_default->content_album_hot ?? old('content_album_hot') !!}</textarea>
		  </div>

		  <!-- Default box -->
		  <div class="card card-solid mt-3">
			<div class="card-header">
			  <h3 class="card-title">Album</h3>
			</div>
			<div class="card-body pb-0">
			  <div class="row d-flex align-items-stretch increment-album-hot">

				@if( isset($album_hot_title) )
					@foreach( $album_hot_title as $key => $w_title )
						@if ($w_title)
						<div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch @if( $key > 0 ) clone-album-hot-cli @endif ">
							<div class="card bg-light">
							  <div class="card-header text-muted border-bottom-0">
								  Ảnh
							  </div>
							  <div class="card-body pt-0">
								  <div class="form-group">
									  <label for="album_hot_title">Tiêu Đề</label>
									  <input type="text" id="album_hot_title" name="album_hot_title[]" placeholder="Nhập tiêu đề" class="form-control" value="{{ $w_title ?? '' }}">
								  </div>
	  
								  <div class="form-group">
									  <label for="album_hot_alt_images">Mô tả Hình Ảnh</label>
									  <input type="text" id="album_hot_alt_images" name="album_hot_alt_images[]" placeholder="Nhập alt" class="form-control" value="{{ $album_hot_alt_images[$key] ?? '' }}">
								  </div>
	  
								  <div class="form-group">
									  <div id="holder-album-hot-{{ $key }}" class="thumbnail text-center">
										  <img src="{{ $album_hot_images[$key] }}" style="height: 5rem;">
									  </div>
									  <div class="input-group">
										  <span class="input-group-btn">
											  <a data-input="thumbnail-album-hot-{{ $key }}" data-preview="holder-album-hot-{{ $key }}" class="lfm-mul btn btn-primary">
											  <i class="fa fa-picture-o"></i> Chọn Ảnh
											  </a>
										  </span>
										  <input id="thumbnail-album-hot-{{ $key }}" class="form-control" type="text" name="album_hot_images[]" value="{{ $album_hot_images[$key] }}" >
									  </div>
								  </div>
							  </div>
	  
							  @if( $key > 0 )
								<div class="card-footer">
								  <div class="text-right">
									<button class="btn btn-sm btn-danger btn-remove-album-hot" type="button">
									  <i class="fas fa-trash"></i> Xóa
									</button>
								  </div>
								</div>
							  @endif
	  
							</div>
						  </div>
						@endif
					@endforeach
				@else
				  <div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch">
					<div class="card bg-light">
					  <div class="card-header text-muted border-bottom-0">
						Ảnh
					  </div>
					  <div class="card-body pt-0">
						<div class="form-group">
							<label for="album_hot_title">Tiêu Đề</label>
							<input type="text" id="album_hot_title" name="album_hot_title[]" placeholder="Nhập tiêu đề" class="form-control" value="">
						</div>

						<div class="form-group">
							<label for="album_hot_alt_images">Mô tả Hình Ảnh</label>
							<input type="text" id="album_hot_alt_images" name="album_hot_alt_images[]" placeholder="Nhập alt" class="form-control" value="">
						</div>

						<div class="form-group">
							<div id="holder-album-hot-0" class="thumbnail text-center"></div>
							<div class="input-group">
								<span class="input-group-btn">
									<a data-input="thumbnail-album-hot-0" data-preview="holder-album-hot-0" class="lfm-mul btn btn-primary">
									<i class="fa fa-picture-o"></i> Chọn Ảnh
									</a>
								</span>
								<input id="thumbnail-album-hot-0" class="form-control" type="text" name="album_hot_images[]" >
							</div>
						</div>
					  </div>
					</div>
				  </div>
				@endif

			  </div>

			  <div class="form-group text-right">
				<button data-count="{{count($album_hot_title ?? []) }}" class="btn-clone-album-hot btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Ảnh</button>
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


@include('backend.includes.clone-album-hot')