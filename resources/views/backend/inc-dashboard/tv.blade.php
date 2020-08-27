<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Truyền Hình</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="form-group">
				<label>Tiêu đề</label>
				<input type="text" class="form-control" name="title_tv" value="{{$home_default->title_tv ?? ''}}">
			</div>
            <div id="holder-tv" class="thumbnail holder-thumbnail text-center">
                @if( !empty( $home_default->images_tv ) )
                    <img src="{{ $home_default->images_tv }}" style="height: 5rem;">
                @endif
            </div>
            <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-tv" data-preview="holder-tv" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
                <input id="thumbnail-tv" class="form-control" type="text" name="images_tv" value="{{ $home_default->images_tv }}">
            </div>
			<div class="form-group">
				<label>Mô tả</label>
				<textarea class="form-control ckeditor" name="description_tv">
					{{$home_default->description_tv ?? ''}}
				</textarea>
			</div>
		  <div class="form-group block-search-appliesto">
			<label for="seo_title">Chọn Truyền Hình</label><br/>
			<button class="btn btn-info tv_search" type="button" data-toggle="modal" data-target="#modal-lg-tv" search="inTv" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
		  </div>
		  <div class="form-group">
			<ul class="todo-list appliesto-value block-tv-list" data-widget="todo-list">

			  @if( !empty( $related_tvs ) && count( $related_tvs ) > 0 )
				@foreach( $related_tvs as $tv )
				  @php
					$images = $tv->images ?? asset('assets/admin/dist/img/no_image.png');
				  @endphp
				  <li class="ul-item {{ $tv->id }}">
					  <input type="hidden" name="related_tv[]" value="{{ $tv->id }}">
					  <!-- drag handle -->
					  <span class="handle">
						<i class="fas fa-ellipsis-v"></i>
						<i class="fas fa-ellipsis-v"></i>
					  </span>
					  <img width="40px" height="40px" src="{{ $images }}">
					  <span class="text">
						  <a href="">{{ $tv->name }}</a>
					  </span>
					  <div class="tools">
						  <div class="remove-item__action" itemID="{{ $tv->id }}"><i class="fas fa-trash"></i></div>
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
