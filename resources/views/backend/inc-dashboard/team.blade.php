<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Đội Ngũ Nhân Viên</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">

		  <div class="form-group">
			<label for="title_team">Tiêu Đề</label>
			<div class="input-group">
			  <div class="input-group-prepend">
				<span class="input-group-text">@</span>
			  </div>
			  <input type="text" id="title_team" name="title_team" value="{{ $home_default->title_team ?? old('title_team') }}" class="form-control" placeholder="Tiêu Đề">
			</div>
		  </div>

		  <div id="holder-team" class="thumbnail holder-thumbnail text-center">
			@if( !empty( $home_default->images_team ) )
			  <img src="{{ $home_default->images_team }}" style="height: 5rem;">
			@endif
		  </div>
		  <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-team" data-preview="holder-team" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
			<input id="thumbnail-team" class="form-control" type="text" name="images_team" value="{{ $home_default->images_team }}">
		  </div>
		  
		  <div class="form-group mt-3">
			<label for="content_team">Mô Tả</label>
			<textarea id="content_team" name="content_team" class="form-control ckeditor-lfm" rows="4">{!! $home_default->content_team ?? old('content_team') !!}</textarea>
		  </div>

		  <div class="form-group block-search-appliesto mt-3">
			<label for="seo_title">Chọn Đội Ngũ Nhân Viên </label><br/>
			<button class="btn btn-info team_search" type="button" data-toggle="modal" data-target="#modal-lg-team" search="inTeam" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
		  </div>
		  <div class="form-group">
			<ul class="todo-list appliesto-value block-team-list" data-widget="todo-list">

			  @if( !empty( $related_teams ) && count( $related_teams ) > 0 )
				@foreach( $related_teams as $team )
				  @php
					$images = $team->images ?? asset('assets/admin/dist/img/no_image.png');
				  @endphp
				  <li class="ul-item {{ $team->id }}">
					  <input type="hidden" name="related_team[]" value="{{ $team->id }}">
					  <!-- drag handle -->
					  <span class="handle">
						<i class="fas fa-ellipsis-v"></i>
						<i class="fas fa-ellipsis-v"></i>
					  </span>
					  <img width="40px" height="40px" src="{{ $images }}">
					  <span class="text">
						  <a href="">{{ $team->name }}</a>
					  </span>
					  <div class="tools">
						  <div class="remove-item__action" itemID="{{ $team->id }}"><i class="fas fa-trash"></i></div>
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