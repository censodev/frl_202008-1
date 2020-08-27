<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Chứng Nhận</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="form-group">
				<label>Tiêu đề</label>
				<input type="text" class="form-control" name="title_certify" value="{{$home_default->title_certify ?? ''}}">
			</div>
            <div id="holder-certify" class="thumbnail holder-thumbnail text-center">
                @if( !empty( $home_default->images_certify ) )
                    <img src="{{ $home_default->images_certify }}" style="height: 5rem;">
                @endif
            </div>
            <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-certify" data-preview="holder-certify" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
                <input id="thumbnail-certify" class="form-control" type="text" name="images_certify" value="{{ $home_default->images_certify }}">
            </div>
			<div class="form-group">
				<label>Mô tả</label>
				<textarea class="form-control ckeditor" name="description_certify">
					{{$home_default->description_certify ?? ''}}
				</textarea>
			</div>
		  <div class="form-group block-search-appliesto">
			<label for="seo_title">Chọn chứng nhận</label><br/>
			<button class="btn btn-info certify_search" type="button" data-toggle="modal" data-target="#modal-lg-certify" search="inCertify" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
		  </div>
		  <div class="form-group">
			<ul class="todo-list appliesto-value block-certify-list" data-widget="todo-list">

			  @if( !empty( $related_certifies ) && count( $related_certifies ) > 0 )
				@foreach( $related_certifies as $certify )
				  @php
                      $certify_images = json_decode( $certify->images );
                      $images = $certify_images[0] ?? asset('assets/admin/dist/img/no_image.png');
				  @endphp
				  <li class="ul-item {{ $certify->id }}">
					  <input type="hidden" name="related_certify[]" value="{{ $certify->id }}">
					  <!-- drag handle -->
					  <span class="handle">
						<i class="fas fa-ellipsis-v"></i>
						<i class="fas fa-ellipsis-v"></i>
					  </span>
					  <img width="40px" height="40px" src="{{ $images }}">
					  <span class="text">
						  <a href="">{{ $certify->name }}</a>
					  </span>
					  <div class="tools">
						  <div class="remove-item__action" itemID="{{ $certify->id }}"><i class="fas fa-trash"></i></div>
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
