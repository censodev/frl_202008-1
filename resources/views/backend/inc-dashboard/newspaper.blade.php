<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Báo Chí</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="form-group">
				<label>Tiêu đề</label>
				<input type="text" class="form-control" name="title_newspaper" value="{{$home_default->title_newspaper ?? ''}}">
			</div>
            <div id="holder-newspaper" class="thumbnail holder-thumbnail text-center">
                @if( !empty( $home_default->images_newspaper ) )
                    <img src="{{ $home_default->images_newspaper }}" style="height: 5rem;">
                @endif
            </div>
            <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-newspaper" data-preview="holder-newspaper" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
                <input id="thumbnail-newspaper" class="form-control" type="text" name="images_newspaper" value="{{ $home_default->images_newspaper }}">
            </div>
			<div class="form-group">
				<label>Mô tả</label>
				<textarea class="form-control ckeditor" name="description_newspaper">
					{{$home_default->description_newspaper ?? ''}}
				</textarea>
			</div>
		  <div class="form-group block-search-appliesto">
			<label for="seo_title">Chọn Báo Chí</label><br/>
			<button class="btn btn-info newspaper_search" type="button" data-toggle="modal" data-target="#modal-lg-newspaper" search="inNewspaper" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
		  </div>
		  <div class="form-group">
			<ul class="todo-list appliesto-value block-newspaper-list" data-widget="todo-list">

			  @if( !empty( $related_newspapers ) && count( $related_newspapers ) > 0 )
				@foreach( $related_newspapers as $newspaper )
				  @php
					$images = $newspaper->images ?? asset('assets/admin/dist/img/no_image.png');
				  @endphp
				  <li class="ul-item {{ $newspaper->id }}">
					  <input type="hidden" name="related_newspaper[]" value="{{ $newspaper->id }}">
					  <!-- drag handle -->
					  <span class="handle">
						<i class="fas fa-ellipsis-v"></i>
						<i class="fas fa-ellipsis-v"></i>
					  </span>
					  <img width="40px" height="40px" src="{{ $images }}">
					  <span class="text">
						  <a href="">{{ $newspaper->name }}</a>
					  </span>
					  <div class="tools">
						  <div class="remove-item__action" itemID="{{ $newspaper->id }}"><i class="fas fa-trash"></i></div>
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
