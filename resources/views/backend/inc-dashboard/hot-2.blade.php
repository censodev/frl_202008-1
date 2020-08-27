<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Section Sản Phẩm Nổi Bật</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" class="form-control" name="title_hot_2" value="{{$home_default->title_hot_2 ?? ''}}">
                </div>

                <div id="holder-hot" class="thumbnail holder-thumbnail text-center">
                    @if( !empty( $home_default->images_hot_2 ) )
                        <img src="{{ $home_default->images_hot_2 }}" style="height: 5rem;">
                    @endif
                </div>
                <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-hot_2" data-preview="holder-funfact" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
                    <input id="thumbnail-hot_2" class="form-control" type="text" name="images_hot_2" value="{{ $home_default->images_hot_2 }}">
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea class="form-control ckeditor" name="description_hot_2">
					{{$home_default->description_hot_2 ?? ''}}
				</textarea>
                </div>
                <div class="form-group block-search-appliesto">
                    <label for="seo_title">Chọn Sản Phẩm Nổi Bật</label><br/>
                    <button class="btn btn-info hot_search_2" type="button" data-toggle="modal" data-target="#modal-lg-hot_2" search="inHot_2" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
                </div>
                <div class="form-group">
                    <ul class="todo-list appliesto-value block-hot-2-list" data-widget="todo-list">

                        @if( !empty( $related_hot2s ) && count( $related_hot2s ) > 0 )
                            @foreach( $related_hot2s as $hot2 )
                                @php
                                    $images = $hot2->images ?? asset('assets/admin/dist/img/no_image.png');
                                @endphp
                                <li class="ul-item {{ $hot2->id }}">
                                    <input type="hidden" name="related_hot_2[]" value="{{ $hot2->id }}">
                                    <!-- drag handle -->
                                    <span class="handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                      </span>
                                        <img width="40px" height="40px" src="{{ $images }}">
                                        <span class="text">
                                            <a href="">{{ $hot2->name }}</a>
                                        </span>
                                    <div class="tools">
                                        <div class="remove-item__action" itemID="{{ $hot2->id }}"><i class="fas fa-trash"></i></div>
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
