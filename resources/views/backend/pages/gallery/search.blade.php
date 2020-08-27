@if(isset($isAppend) && $isAppend)
	<ul class="todo-list" data-widget="todo-list">
		@foreach($galleries as $key => $gallery)
			@php
				$gallery_images     = json_decode( $gallery->images );
				$images 			= $gallery_images[0] ?? asset('assets/admin/dist/img/no_image.png');
			@endphp

			<li class="ul-item {{$gallery->id}}">
                <span class="handle">
                  	<i class="fas fa-ellipsis-v"></i>
                  	<i class="fas fa-ellipsis-v"></i>
                </span>
                <div  class="icheck-primary d-inline ml-2">
                  	<input type="checkbox" value="{{$gallery->id}}" name="applies_value[{{$gallery->id}}]['id']" id="todoCheck-gallery-{{ $key }}">
                  	<label for="todoCheck-gallery-{{ $key }}"></label>
                </div>
                <img src="{{ $images }}" width="40px" height="40px">
                <span class="text">{{ $gallery->title }}</span>
          	</li>

		@endforeach
	</ul>
@else
	<div class="modal fade" id="modal-lg-gallery">
	  	<div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      	<div class="modal-header">
			        <h4 class="modal-title">Large Modal</h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          	<span aria-hidden="true">&times;</span>
			        </button>
		      	</div>
		      	<div class="modal-body">
		        	<form action="" id="formAddItem" method="post">
						<div class="input-group block-search-appliesto inGallery">
		                  	<input type="text" class="form-control">
		                  	<span class="input-group-append">
		                    	<button type="button" class="btn btn-info btn-flat gallery_search" search="inGallery" is-append="1">Tìm Kiếm</button>
		                  	</span>
		                </div>

		                <div class="block-gallery-list">
							<ul class="todo-list" data-widget="todo-list">
								@foreach($galleries as $key => $gallery)
									@php
										$gallery_images     = json_decode( $gallery->images );
										$images 			= $gallery_images[0] ?? asset('assets/admin/dist/img/no_image.png');
									@endphp

									<li class="ul-item {{$gallery->id}}">
					                    <span class="handle">
					                      	<i class="fas fa-ellipsis-v"></i>
					                      	<i class="fas fa-ellipsis-v"></i>
					                    </span>
					                    <div  class="icheck-primary d-inline ml-2">
					                      	<input type="checkbox" value="{{$gallery->id}}" name="applies_value[{{$gallery->id}}]['id']" id="todoCheck-gallery-{{ $key }}">
					                      	<label for="todoCheck-gallery-{{ $key }}"></label>
					                    </div>
					                    <img src="{{ $images }}" width="40px" height="40px">
					                    <span class="text">{{ $gallery->title }}</span>
					              	</li>

								@endforeach
							</ul>
		                </div>
		        	</form>
		      	</div>
		      	<div class="modal-footer justify-content-between">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
			        <button type="button" class="btn btn-primary addappliesto {{ @$type_search }}">Lưu</button>
		      	</div>
		    </div>
		    <!-- /.modal-content -->
	  	</div>
	  	<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->

	<script>
	  	$('#formAddItem input').on('keypress', function(e) {
	    	var keyCode = e.keyCode || e.which;
	    	if (keyCode === 13) {
		      	e.preventDefault();
		      	return false;
	    	}
	  	});
	</script>
@endif