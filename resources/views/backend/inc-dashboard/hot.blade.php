<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Danh Mục Nổi Bật</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="form-group">
				<label>Tiêu đề</label>
				<input type="text" class="form-control" name="title_hot" value="{{$home_default->title_hot ?? ''}}">
			</div>


            {{-- <div id="holder-hot" class="thumbnail holder-thumbnail text-center">
                @if( !empty( $home_default->images_hot ) )
                    <img src="{{ $home_default->images_hot }}" style="height: 5rem;">
                @endif
            </div>
            <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-hot" data-preview="holder-funfact" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
                <input id="thumbnail-hot" class="form-control" type="text" name="images_hot" value="{{ $home_default->images_hot }}">
            </div> --}}

			<div class="form-group">
				<label>Mô tả</label>
				<textarea class="form-control ckeditor" name="description_hot">
					{{$home_default->description_hot ?? ''}}
				</textarea>
			</div>
		  <div class="form-group block-search-appliesto">
			<label for="seo_title">Chọn Danh Mục Nổi Bật</label><br/>
			<button class="btn btn-info hot_search" type="button" data-toggle="modal" data-target="#modal-lg-hot" search="inHot" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
		  </div>
		  <div class="form-group">
			<ul class="todo-list appliesto-value block-hot-list" data-widget="todo-list">

			  @if( !empty( $related_hots ) && count( $related_hots ) > 0 )
				@foreach( $related_hots as $hot )
				  @php
					$images = $hot->images ?? asset('assets/admin/dist/img/no_image.png');
				  @endphp
				  <li class="ul-item {{ $hot->id }}">
					  <input type="hidden" name="related_hot[]" value="{{ $hot->id }}">
					  <!-- drag handle -->
					  <span class="handle">
						<i class="fas fa-ellipsis-v"></i>
						<i class="fas fa-ellipsis-v"></i>
					  </span>
					  <img width="40px" height="40px" src="{{ $images }}">
					  <span class="text">
						  <a href="">{{ $hot->name }}</a>
					  </span>
					  <div class="tools">
						  <div class="remove-item__action" itemID="{{ $hot->id }}"><i class="fas fa-trash"></i></div>
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
