@php
	$keyword	   = $data['keyword'] ?? '';
	$create_new	   = $data['create_new'] ?? '';
	$tmp_cat 	   = $data['tmp_cat'] ?? -1;
	$category_list = $data['category_list'] ?? '';
@endphp
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-9">
				<form class="form-inline md-form form-sm active-cyan-2">
					@if( !empty( $category_list ) )
						<select class="form-control form-control-sm mr-2" name="cat">
							<option selected value>--- Chọn Danh Mục ---</option>
							@foreach( $category_list as $cat )
								<option value="{{$cat->id}}" <?php if( $cat->id == $tmp_cat){ echo "selected"; }?> >{{$cat->title}}</option>
							@endforeach
						</select>
					@endif
					
					<input class="form-control form-control-sm w-50" type="text" name="keyword" value="{{ $keyword }}" placeholder="Tìm Kiếm" aria-label="Tìm Kiếm">
					<button class="btn btn-navbar" type="submit">
						<i class="fas fa-search active" aria-hidden="true"></i>
					</button>
				</form>
			</div>
			
			@if( !empty( $create_new ) )
				<div class="col-md-3">
					<a href="{{ $create_new }}" class="btn btn-success">Thêm Mới <span class="fa fa-plus"></span></a>
				</div>
			@endif
		</div>
	</div>
</div>