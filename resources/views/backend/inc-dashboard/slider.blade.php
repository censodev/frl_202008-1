<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Slider</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group block-search-appliesto">
			<label for="seo_title">Chọn Slider <span class="color-red">( Chỉ chọn 1 danh sách Slider )</span></label><br/>
			<button class="btn btn-info slider_search" type="button" data-toggle="modal" data-target="#modal-lg-slider" search="inSlider" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
		  </div>
		  <div class="form-group">
			<ul class="todo-list appliesto-value block-slider-list" data-widget="todo-list">

			  @if( !empty( $related_sliders ) && count( $related_sliders ) > 0 )
				@foreach( $related_sliders as $slider )
				  @php
					$slider_images = json_decode( $slider->images );
					$images = $slider_images[0] ?? asset('assets/admin/dist/img/no_image.png');
				  @endphp
				  <li class="ul-item {{ $slider->id }}">
					  <input type="hidden" name="related_slider[]" value="{{ $slider->id }}">
					  <!-- drag handle -->
					  <span class="handle">
						<i class="fas fa-ellipsis-v"></i>
						<i class="fas fa-ellipsis-v"></i>
					  </span>
					  <img width="40px" height="40px" src="{{ $images }}">
					  <span class="text">
						  <a href="">{{ $slider->title }}</a>
					  </span>
					  <div class="tools">
						  <div class="remove-item__action" itemID="{{ $slider->id }}"><i class="fas fa-trash"></i></div>
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
