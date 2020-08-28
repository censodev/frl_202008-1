<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Chế Độ Hậu Mãi</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="form-group">
				<label>Tiêu đề</label>
				<input type="text" class="form-control" name="title_endow" value="{{$home_default->title_endow ?? ''}}">
			</div>

            {{-- <div id="holder-endow" class="thumbnail holder-thumbnail text-center">
                @if( !empty( $home_default->images_endow ) )
                    <img src="{{ $home_default->images_endow }}" style="height: 5rem;">
                @endif
            </div>
            <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-endow" data-preview="holder-endow" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
                <input id="thumbnail-endow" class="form-control" type="text" name="images_endow" value="{{ $home_default->images_endow }}">
            </div> --}}
			<div class="form-group">
				<label>Mô tả</label>
				<textarea class="form-control ckeditor" name="description_endow">
					{{$home_default->description_endow ?? ''}}
				</textarea>
			</div>
		  <div class="form-group block-search-appliesto">
			<label for="seo_title">Chọn Chế Độ Hậu Mãi</label><br/>
			<button class="btn btn-info endow_search" type="button" data-toggle="modal" data-target="#modal-lg-endow" search="inEndow" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
		  </div>
		  <div class="form-group">
			<ul class="todo-list appliesto-value block-endow-list" data-widget="todo-list">

			  @if( !empty( $related_endows ) && count( $related_endows ) > 0 )
				@foreach( $related_endows as $endow )
				  @php
					$images = $endow->images ?? asset('assets/admin/dist/img/no_image.png');
				  @endphp
				  <li class="ul-item {{ $endow->id }}">
					  <input type="hidden" name="related_endow[]" value="{{ $endow->id }}">
					  <!-- drag handle -->
					  <span class="handle">
						<i class="fas fa-ellipsis-v"></i>
						<i class="fas fa-ellipsis-v"></i>
					  </span>
					  <img width="40px" height="40px" src="{{ $images }}">
					  <span class="text">
						  <a href="">{{ $endow->name }}</a>
					  </span>
					  <div class="tools">
						  <div class="remove-item__action" itemID="{{ $endow->id }}"><i class="fas fa-trash"></i></div>
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
