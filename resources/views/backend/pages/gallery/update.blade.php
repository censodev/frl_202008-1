@extends($data->layout)

@section('title')
  {{ $data->title }}
@endsection

@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $data->title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Trang Quản Trị</a></li>
              <li class="breadcrumb-item active">{{ $data->title }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @php
      $gallery  = $data['gallery'];
      $url_id   = $data['url_id'];

      $gallery_images       = json_decode( $gallery->images );
      $gallery_title_image  = json_decode( $gallery->title_image );
      $gallery_alt_image    = json_decode( $gallery->alt_image );
      $gallery_videos       = json_decode( $gallery->videos );

      $related_posts        = $data['related_posts'];
      $related_galleries    = $data['related_galleries'];
    @endphp

    <!-- Main content -->
    <section class="content">
      <form role="form" action="{{ route('gallery.update',$gallery->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $gallery->id }}">
        <input type="hidden" name="url_id" value="{{ $url_id }}">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Trường SEO</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">

                <div class="form-group">
                  <label for="seo_title">SEO Tiêu Đề <span id="seotitleerror" class="error alert-danger"><span class="change-text">Chuẩn SEO</span> <span id="validatetitleseo"> </span>/60 kí tự</span></label>
                  <input type="text" id="seo_title" name="seo_title" placeholder="Nhập Seo tiêu đề" class="form-control" value="{{ $gallery->seo_title ?? old('seo_title') }}">
                </div>

                <div class="form-group">
                  <label for="seo_keyword">SEO Từ Khóa</label>
                  <input type="text" id="seo_keyword" name="seo_keyword" placeholder="Nhập Seo từ khóa" class="form-control" value="{{ $gallery->seo_keyword ?? old('seo_keyword') }}">
                </div>

                <div class="form-group">
                  <label for="seo_desciption">SEO Mô Tả <span id="seodeserror" class="error alert-danger" ><span class="change-text">Chuẩn SEO</span> <span id="validateseomota"></span>/160 kí tự</span></label>
                  <input type="text" id="seo_desciption" name="seo_desciption" placeholder="Nhập Seo mô tả" class="form-control" value="{{ $gallery->seo_desciption ?? old('seo_desciption') }}">
                </div>

                <div class="form-group">
                  <label for="seo_google">Thẻ Tiếp Thị Remarketing</label>
                  <input type="text" id="seo_google" name="seo_google" placeholder="Nhập tiếp thị Google" class="form-control" value="{{ $gallery->seo_google ?? old('seo_google') }}">
                </div>

                <div class="form-group">
                  <label for="seo_facebook">Thẻ Pixel Facebook</label>
                  <input type="text" id="seo_facebook" name="seo_facebook" placeholder="Nhập Pixel Facebook" class="form-control" value="{{ $gallery->seo_facebook ?? old('seo_facebook') }}">
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Trường Chính</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label for="title">Tên Bộ Sưu Tập</label>
                  <input type="text" id="title" name="title" value="{{ $gallery->title ?? old('title') }}" class="form-control" required placeholder="Nhập tên bộ sưu tập" oninvalid="this.setCustomValidity('Vui lòng nhập tên bộ sưu tập.')" oninput="setCustomValidity('')">
                  @if( $errors->has('title') )
                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="alias">Đường Dẫn Thân Thiện</label>
                  <input type="text" id="alias" name="alias" value="{{ $gallery->alias ?? old('alias') }}" class="form-control" required placeholder="Nhập đường dẫn thân thiện" oninvalid="this.setCustomValidity('Vui lòng nhập đường dẫn thân thiện.')" oninput="setCustomValidity('')">
                  @if( $errors->has('alias') )
                    <div class="alert alert-danger">{{ $errors->first('alias') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="category_id">Chọn Danh Mục ( Bộ Sưu Tập )</label>
                  <select class="form-control custom-select" name="category_id" required oninvalid="this.setCustomValidity('Vui lòng chọn danh mục cha.')" oninput="setCustomValidity('')">
                    <option selected disabled>--- Chọn Danh Mục ---</option>
                    @php
                      $level = 0;
                      $category_level = $data['category_level']->toArray();
                      showListCategory($category_level,$level,$gallery->category_id);
                    @endphp
                  </select>
                  @if( $errors->has('category_id') )
                    <div class="alert alert-danger">{{ $errors->first('category_id') }}</div>
                  @endif
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="view">Lượt Xem</label>
                      <input type="number" id="view" name="view" placeholder="Nhập lượt xem" class="form-control" value="{{ $gallery->view ?? old('view') }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="rating">Số Sao Đánh Giá ( Từ 1 -> 5 )</label>
                      <input type="number" id="rating" name="rating" placeholder="Nhập số sao đánh giá" class="form-control" max="5" value="{{ $gallery->rating ?? old('rating') }}">
                    </div>
                  </div>
                </div>

                <!-- Default box -->
                <div class="card card-solid">
                  <div class="card-header">
                    <h3 class="card-title">Ảnh Gallery</h3>
                  </div>
                  <div class="card-body pb-0">
                    <div class="row d-flex align-items-stretch increment-thumbnail">

                      @if( !empty( $gallery_images ) && count( $gallery_images ) > 0 )
                        @foreach( $gallery_images as $key => $images )
                          <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch @if( $key > 0 ) clone-thumbnail-cli @endif ">
                            <div class="card bg-light">
                              <div class="card-header text-muted border-bottom-0">
                                Hình Ảnh
                              </div>
                              <div class="card-body pt-0">
                                <div class="form-group">
                                  <div id="holder-{{ $key }}" class="thumbnail holder-thumbnail text-center">
                                    <img src="{{ $images }}" style="height: 5rem;">
                                  </div>
                                  <div class="input-group">
                                    <span class="input-group-btn">
                                      <a data-input="thumbnail-{{ $key }}" data-preview="holder-{{ $key }}" class="lfm-mul btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Chọn Ảnh
                                      </a>
                                    </span>
                                    <input id="thumbnail-{{ $key }}" class="form-control" type="text" name="images[]" value="{{ $images }}" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label for="title_image">Tiêu Đề Hình Ảnh</label>
                                  <input type="text" id="title_image" name="title_image[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ $gallery_title_image[$key] ?? '' }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                </div>

                                <div class="form-group">
                                  <label for="alt_image">Mô Tả Hình Ảnh</label>
                                  <input type="text" id="alt_image" name="alt_image[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ $gallery_alt_image[$key] ?? '' }}" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                </div>
                              </div>

                              @if( $key > 0 )
                                <div class="card-footer">
                                  <div class="text-right">
                                    <button class="btn btn-sm btn-danger btn-remove-thumbnail" type="button">
                                      <i class="fas fa-trash"></i> Xóa
                                    </button>
                                  </div>
                                </div>
                              @endif

                            </div>
                          </div>
                        @endforeach

                      @else
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                          <div class="card bg-light">
                            <div class="card-header text-muted border-bottom-0">
                              Hình Ảnh
                            </div>
                            <div class="card-body pt-0">
                              <div class="form-group">
                                <div id="holder" class="thumbnail text-center"></div>
                                <div class="input-group">
                                  <span class="input-group-btn">
                                    <a data-input="thumbnail" data-preview="holder" class="lfm-mul btn btn-primary">
                                      <i class="fa fa-picture-o"></i> Chọn Ảnh
                                    </a>
                                  </span>
                                  <input id="thumbnail" class="form-control" type="text" name="images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="title_image">Tiêu Đề Hình Ảnh</label>
                                <input type="text" id="title_image" name="title_image[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                              </div>

                              <div class="form-group">
                                <label for="alt_image">Mô Tả Hình Ảnh</label>
                                <input type="text" id="alt_image" name="alt_image[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                              </div>
                            </div>
                          </div>
                        </div>
                      @endif

                    </div>

                    <div class="form-group text-right">
                      @if( !empty( $gallery_images ) && count( $gallery_images ) > 0 )
                        <button class="btn-clone-thumbnail btn btn-info" data-count="{{ count( $gallery_images ) }}" type="button"><i class="fas fa-plus"></i> Thêm Hình Ảnh</button>
                      @else
                        <button class="btn-clone-thumbnail btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Hình Ảnh</button>
                      @endif
                    </div>

                  </div>
                </div>

                <!-- Default box -->
                <div class="card card-solid">
                  <div class="card-body pb-0">

                    @php
                      $html_iframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/5jqjxHAVA7I" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                    @endphp
                    <div class="form-group"><strong>Ví dụ: </strong> {{ $html_iframe }}</div>

                    <div class="row d-flex align-items-stretch increment-video">

                      @if( !empty( $gallery_videos ) && count( $gallery_videos ) > 0 )
                        @foreach( $gallery_videos as $key => $videos )
                          <div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch @if( $key > 0 ) clone-video-cli @endif ">
                            <div class="card bg-light">
                              <div class="card-header text-muted border-bottom-0">
                                Embed Video
                              </div>
                              <div class="card-body pt-0">

                                <div class="form-group">
                                  <textarea name="videos[]" class="form-control" rows="3" placeholder="Nhập embed video">{{ $videos }}</textarea>
                                </div>

                              </div>

                              @if( $key > 0 )
                                <div class="card-footer">
                                  <div class="text-right">
                                    <button class="btn btn-sm btn-danger btn-remove-video" type="button">
                                      <i class="fas fa-trash"></i> Xóa
                                    </button>
                                  </div>
                                </div>
                              @endif

                            </div>
                          </div>
                        @endforeach

                      @else
                        <div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch">
                          <div class="card bg-light">
                            <div class="card-header text-muted border-bottom-0">
                              Embed Video
                            </div>
                            <div class="card-body pt-0">

                              <div class="form-group">
                                <textarea name="videos[]" class="form-control" rows="3" placeholder="Nhập embed video"></textarea>
                              </div>

                            </div>
                          </div>
                        </div>
                      @endif

                    </div>

                    <div class="form-group text-right">
                      <button class="btn-clone-video btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Embed Video</button>
                    </div>

                  </div>
                </div>

                <div class="form-group">
                  <label for="sapo">Sapo</label>
                  <textarea id="sapo" name="sapo" class="form-control" rows="4">{!! $gallery->sapo ?? old('sapo') !!}</textarea>
                </div>

                <div class="form-group">
                  <label for="description">Mô Tả</label>
                  <textarea id="description" name="description" class="form-control" rows="4">{!! $gallery->description ?? old('description') !!}</textarea>
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-md-12">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Trường Liên Quan</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
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

                  <div class="col-md-6">
                    <div class="form-group block-search-appliesto">
                      <label for="seo_title">Bộ Sưu Tập</label><br/>
                      <button class="btn btn-info gallery_search" type="button" data-toggle="modal" data-target="#modal-lg-gallery" search="inGallery" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
                    </div>
                    <div class="form-group">
                      <ul class="todo-list appliesto-value block-gallery-list" data-widget="todo-list">

                        @if( !empty( $related_galleries ) && count( $related_galleries ) > 0 )
                          @foreach( $related_galleries as $related_gallery )
                            @php
                              $gallery_images = json_decode( $related_gallery->images );
                              $images = $gallery_images[0] ?? asset('assets/admin/dist/img/no_image.png');
                            @endphp
                            <li class="ul-item {{ $related_gallery->id }}">
                                <input type="hidden" name="related_gallery[]" value="{{ $related_gallery->id }}">
                                <!-- drag handle -->
                                <span class="handle">
                                  <i class="fas fa-ellipsis-v"></i>
                                  <i class="fas fa-ellipsis-v"></i>
                                </span>
                                <img width="40px" height="40px" src="{{ $images }}">
                                <span class="text">
                                    <a href="">{{ $related_gallery->title }}</a>
                                </span>
                                <div class="tools">
                                    <div class="remove-item__action" itemID="{{ $related_gallery->id }}"><i class="fas fa-trash"></i></div>
                                </div>
                            </li>
                          @endforeach
                        @endif

                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <div class="row">
          <div class="card-body text-center">
            <button type="submit" name="save_and_exits" value="1" class="btn btn-success" role="button">
              Lưu Và Thoát
            </button>
            <button type="submit" name="save_and_exits" value="2" class="btn btn-success" role="button">
              Lưu
            </button>
            <a href="{{ route('gallery.index') }}" class="btn btn-secondary">Thoát</a>
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->

    <!-- Clone -->
    @include('backend.includes.clone-image')

    @include('backend.includes.clone-video')

@endsection