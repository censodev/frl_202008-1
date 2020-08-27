<div class="row">
	<div class="col-12">
	  <div class="card card-primary">
		<div class="card-header">
		  <h3 class="card-title">Section Banner</h3>
		  <div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			  <i class="fas fa-minus"></i></button>
		  </div>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
           <div class="row">
               <div class="col-md-6">
                   <div id="holder-thumbnail-content-1" class="thumbnail holder-thumbnail text-center">
                       @if( !empty( $home_default->banner_content_1 ) )
                           <img src="{{ $home_default->banner_content_1 }}" style="height: 5rem;">
                       @endif
                   </div>
                   <div class="input-group">
                        <span class="input-group-btn">
                          <a data-input="thumbnail-content-1" data-preview="holder-thumbnail-content-1" class="lfm-mul btn btn-primary">
                            <i class="fa fa-picture-o"></i> Hình Ảnh
                          </a>
                        </span>
                       <input id="thumbnail-content-1" class="form-control" type="text" name="banner_content_1" value="{{ $home_default->banner_content_1 }}">
                   </div>
                   <div class="row mt-3">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="title_image_about">Tiêu Đề Hình Ảnh</label>
                               <input type="text" name="title_banner_content_1" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ $home_default->title_banner_content_1 ?? old('title_banner_content_1') }}">
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="alt_image_about">Mô Tả Hình Ảnh</label>
                               <input type="text" name="alt_banner_content_1" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ $home_default->alt_banner_content_1 ?? old('alt_banner_content_1') }}">
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-md-6">
                   <div id="holder-thumbnail-content-2" class="thumbnail holder-thumbnail text-center">
                       @if( !empty( $home_default->banner_content_2 ) )
                           <img src="{{ $home_default->banner_content_2 }}" style="height: 5rem;">
                       @endif
                   </div>
                   <div class="input-group">
                        <span class="input-group-btn">
                          <a data-input="thumbnail-content-2" data-preview="holder-thumbnail-content-2" class="lfm-mul btn btn-primary">
                            <i class="fa fa-picture-o"></i> Hình Ảnh
                          </a>
                        </span>
                       <input id="thumbnail-content-2" class="form-control" type="text" name="banner_content_2" value="{{ $home_default->banner_content_2 }}">
                   </div>
                   <div class="row mt-3">
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="title_image_about">Tiêu Đề Hình Ảnh</label>
                               <input type="text" name="title_banner_content_2" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ $home_default->title_banner_content_2 ?? old('title_banner_content_2') }}">
                           </div>
                       </div>
                       <div class="col-md-6">
                           <div class="form-group">
                               <label for="alt_image_about">Mô Tả Hình Ảnh</label>
                               <input type="text" name="alt_banner_content_2" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ $home_default->alt_banner_content_2 ?? old('alt_banner_content_2') }}">
                           </div>
                       </div>
                   </div>
               </div>

           </div>

		</div>
		<!-- /.card-body -->
	  </div>
	  <!-- /.card -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->
