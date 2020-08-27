<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Bài Viết Nổi Bật</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-group">
                    <label for="title_product_hot">Tiêu Đề</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input type="text" name="title_post_hot" value="{{ $home_default->title_post_hot ?? old('title_post_hot') }}" class="form-control" placeholder="Tiêu Đề">
                    </div>
                </div>

                <div id="holder-post-hot" class="thumbnail holder-thumbnail text-center">
                    @if( !empty( $home_default->images_post_hot ) )
                        <img src="{{ $home_default->images_post_hot }}" style="height: 5rem;">
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-btn">
                      <a data-input="thumbnail-post-hot" data-preview="holder-post-hot" class="lfm-mul btn btn-primary">
                        <i class="fa fa-picture-o"></i> Ảnh Nền
                      </a>
                    </span>
                    <input id="thumbnail-post-hot" class="form-control" type="text" name="images_post_hot" value="{{ $home_default->images_post_hot }}">
                </div>

                <div class="form-group mt-3">
                    <label for="content_post_hot">Nội Dung</label>
                    <textarea id="content_post_hot" name="content_post_hot" class="form-control ckeditor-lfm" rows="4">{!! $home_default->content_post_hot ?? old('content_post_hot') !!}</textarea>
                </div>

                <div class="col-md-6">
                    <div class="form-group block-search-appliesto">
                        <label for="seo_title">Bài Viết</label><br/>
                        <button class="btn btn-info article_search" type="button" data-toggle="modal" data-target="#modal-lg-article" search="inArticle" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
                    </div>
                    <div class="form-group">
                        <ul class="todo-list appliesto-value block-article-list" data-widget="todo-list">

                            @if( !empty( $related_posts ) && count( $related_posts ) > 0 )
                                @foreach( $related_posts as $related_post )
                                    @php
                                        $images = $related_post->images ?? asset('assets/admin/dist/img/no_image.png');
                                    @endphp
                                    <li class="ul-item {{ $related_post->id }}">
                                        <input type="hidden" name="related_post[]" value="{{ $related_post->id }}">
                                        <!-- drag handle -->
                                        <span class="handle">
                                          <i class="fas fa-ellipsis-v"></i>
                                          <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                        <img width="40px" height="40px" src="{{ $images }}">
                                        <span class="text">
                                            <a href="">{{ $related_post->title }}</a>
                                        </span>
                                        <div class="tools">
                                            <div class="remove-item__action" itemID="{{ $related_post->id }}"><i class="fas fa-trash"></i></div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
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
