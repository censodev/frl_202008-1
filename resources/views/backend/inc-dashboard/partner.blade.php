<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Đối Tác</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="form-group">
				<label>Tiêu đề</label>
				<input type="text" class="form-control" name="title_partner" value="{{$home_default->title_partner ?? ''}}">
			</div>
			<div class="form-group">
				<label>Mô tả</label>
				<textarea class="form-control ckeditor" name="description_partner">
					{{$home_default->description_partner ?? ''}}
				</textarea>
			</div>
		  <div class="form-group block-search-appliesto">
			<label for="seo_title">Chọn Đối Tác</label><br/>
			<button class="btn btn-info partner_search" type="button" data-toggle="modal" data-target="#modal-lg-partner" search="inPartner" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
		  </div>
		  <div class="form-group">
			<ul class="todo-list appliesto-value block-partner-list" data-widget="todo-list">

			  @if( !empty( $related_partners ) && count( $related_partners ) > 0 )
				@foreach( $related_partners as $partner )
				  @php
					$images = $partner->images ?? asset('assets/admin/dist/img/no_image.png');
				  @endphp
				  <li class="ul-item {{ $partner->id }}">
					  <input type="hidden" name="related_partner[]" value="{{ $partner->id }}">
					  <!-- drag handle -->
					  <span class="handle">
						<i class="fas fa-ellipsis-v"></i>
						<i class="fas fa-ellipsis-v"></i>
					  </span>
					  <img width="40px" height="40px" src="{{ $images }}">
					  <span class="text">
						  <a href="">{{ $partner->name }}</a>
					  </span>
					  <div class="tools">
						  <div class="remove-item__action" itemID="{{ $partner->id }}"><i class="fas fa-trash"></i></div>
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
