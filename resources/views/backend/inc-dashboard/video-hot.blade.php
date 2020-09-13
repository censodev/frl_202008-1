<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Video Nổi Bật</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group">
			<label for="title_video_hot">Tiêu Đề</label>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text">@</span>
			  </div>
			  <input type="text" id="title_video_hot" name="title_video_hot" value="{{ $home_default->title_video_hot ?? old('title_video_hot') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  {{-- <div id="holder-video-hot" class="thumbnail holder-thumbnail text-center">
			@if( !empty( $home_default->images_video-hot ) )
			  <img src="{{ $home_default->images_video-hot }}" style="height: 5rem;">
			@endif
		  </div> --}}
		  {{-- <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-video-hot" data-preview="holder-video-hot" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-video-hot" class="form-control" type="text" name="images_video-hot" value="{{ $home_default->images_video-hot }}">
		  </div> --}}

		  <div class="form-group mt-3">
			<label for="content_video_hot">Nội Dung</label>
			<textarea id="content_video_hot" name="content_video_hot" class="form-control ckeditor-lfm" rows="4">{!! $home_default->content_video_hot ?? old('content_video_hot') !!}</textarea>
		  </div>

		  <!-- Default box -->
		  <div class="card card-solid mt-3">
			<div class="card-header">
			  <h3 class="card-title">Videos</h3>
			</div>
			<div class="card-body pb-0">
			  <div class="row d-flex align-items-stretch increment-video-hot">

				@if( isset($video_hot_title) )
					@foreach( $video_hot_title as $key => $w_title )
						@if ($w_title)
							<div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch @if( $key > 0 ) clone-video-hot-cli @endif ">
								<div class="card bg-light">
									<div class="card-header text-muted border-bottom-0">
										Video
									</div>
									<div class="card-body pt-0">
									<div class="form-group">
										<label for="video_hot_title">Tiêu Đề</label>
										<input type="text" id="video_hot_title" name="video_hot_title[]" placeholder="Nhập tiêu đề" class="form-control" value="{{ $w_title ?? '' }}">
									</div>
		
									<div class="form-group">
										<label for="video_hot_embed">Mã Nhúng</label>
										<textarea rows="4" id="video_hot_embed" name="video_hot_embed[]" class="form-control" placeholder="Nhập mã nhúng Youtube">{{ $video_hot_embed[$key] ?? '' }}</textarea>
									</div>
									</div>
		
									@if( $key > 0 )
									<div class="card-footer">
										<div class="text-right">
										<button class="btn btn-sm btn-danger btn-remove-video-hot" type="button">
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
						Video
					  </div>
					  <div class="card-body pt-0">
						<div class="form-group">
						  <label for="video_hot_title">Tiêu Đề</label>
						  <input type="text" id="video_hot_title" name="video_hot_title[]" placeholder="Nhập tiêu đề" class="form-control" value="">
						</div>

						<div class="form-group">
						  <label for="video_hot_embed">Mã Nhúng</label>
						  <textarea rows="4" id="video_hot_embed" name="video_hot_embed[]" class="form-control" placeholder="Nhập mã nhúng"></textarea>
						</div>
					  </div>
					</div>
				  </div>
				@endif

			  </div>

			  <div class="form-group text-right">
				<button class="btn-clone-video-hot btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Video</button>
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

@include('backend.includes.clone-video-hot')