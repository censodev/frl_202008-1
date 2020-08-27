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

    <!-- Main content -->
    <section class="content">
      <form role="form" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        <div class="row">
          <div class="col-md-6">
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
                  <label for="title">Tên Danh Mục</label>
                  <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" required placeholder="Nhập tên danh mục" oninvalid="this.setCustomValidity('Vui lòng nhập tên danh mục.')" oninput="setCustomValidity('')">
                  @if( $errors->has('title') )
                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="alias">Đường Dẫn Thân Thiện</label>
                  <input type="text" id="alias" name="alias" value="{{ old('alias') }}" class="form-control" required placeholder="Nhập đường dẫn thân thiện" oninvalid="this.setCustomValidity('Vui lòng nhập đường dẫn thân thiện.')" oninput="setCustomValidity('')">
                  @if( $errors->has('alias') )
                    <div class="alert alert-danger">{{ $errors->first('alias') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="alias_external">Đường Dẫn Ngoài</label>
                  <input type="text" id="alias_external" name="alias_external" value="{{ old('alias_external') }}" class="form-control" placeholder="Nhập đường dẫn ngoài">
                </div>

                <div class="form-group">
                  <label for="parent_id">Chọn Danh Mục Cha</label>
                  <select class="form-control custom-select" name="parent_id" required oninvalid="this.setCustomValidity('Vui lòng chọn danh mục cha.')" oninput="setCustomValidity('')">
                    <option selected disabled>--- Lựa Chọn ---</option>
                    <option value="-1">Danh mục gốc</option>
                    @foreach($data['category_all'] as $category)
                      <option value="{{$category->id}}">{{ $category->title }}</option>
                    @endforeach
                  </select>
                  @if( $errors->has('parent_id') )
                    <div class="alert alert-danger">{{ $errors->first('parent_id') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="type">Chọn Loại Danh Mục</label>
                  <select class="form-control custom-select" name="type" required oninvalid="this.setCustomValidity('Vui lòng chọn loại danh mục.')" oninput="setCustomValidity('')">
                    <option selected disabled>--- Lựa Chọn ---</option>
                    @foreach($data['category_type'] as $key => $type)
                      <option value="{{ ( $key + 1 ) }}"> {{ $type }}</option>
                    @endforeach
                  </select>
                  @if( $errors->has('type') )
                    <div class="alert alert-danger">{{ $errors->first('type') }}</div>
                  @endif
                </div>

                  <div class="form-group">
                      <label>Chọn section scroll <span class = "maudo">( Chỉ áp dụng cho LandingPage )</span></label>
                      <select name="section_scroll" class="form-control ">
                          <option value="">Chọn Section Scroll</option>
                          @foreach($data['section_scroll'] as $key => $section)
                              <option value="{{ $key }}"> {{ $section }}</option>
                          @endforeach
                      </select>
                  </div>

                <div class="form-group">
                  <label for="show_menu_alias">Chọn Đường Dẫn Hiển Thị</label>
                  <select class="form-control custom-select" name="show_menu_alias">
                    <option value="1">Đường dẫn thân thiện</option>
                    <option value="2">Đường dẫn ngoài</option>
                  </select>
                </div>

                <div id="holder" class="thumbnail text-center"></div>
                <div class="input-group">
                  <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Chọn Ảnh Banner
                    </a>
                  </span>
                  <input id="thumbnail" class="form-control" type="text" name="images">
                </div>
                <div class="row mt-1rem">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title_image">Tiêu Đề Hình Ảnh</label>
                      <input type="text" id="title_image" name="title_image" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ old('title_image') }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alt_image">Mô Tả Hình Ảnh</label>
                      <input type="text" id="alt_image" name="alt_image" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ old('alt_image') }}">
                    </div>
                  </div>
                </div>

                  <div id="holder-number" class="thumbnail thumbnail-clone text-center"></div>
                  <div class="input-group">
                        <span class="input-group-btn">
                          <a data-input="thumbnail-number" data-preview="holder-number" class="lfm-mul btn btn-primary">
                            <i class="fa fa-picture-o"></i> Chọn Ảnh Chi Tiết
                          </a>
                        </span>
                      <input id="thumbnail-number" class="form-control"  value="{{ old('images_detail') }}" type="text" name="images_detail" oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                  </div>

                  <div class="row mt-1rem">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="title_image">Tiêu Đề Hình Ảnh</label>
                              <input type="text" name="title_image_detail" value="{{ old('title_image_detail') }}" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ old('title_image_detail') }}">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="alt_image">Mô Tả Hình Ảnh</label>
                              <input type="text" name="alt_image_detail" value="{{ old('alt_image_detail') }}" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ old('alt_image_detail') }}">
                          </div>
                      </div>
                  </div>

                <div class="form-group">
                  <label for="icons">Icon</label>
                  <input type="text" id="icons" name="icons" placeholder="Nhập icon fontawesome" class="form-control" value="{{ old('icons') }}">
                </div>

                <div class="form-group">
                  <label for="ordering">Sắp Xếp Vị Trí</label>
                  <input type="number" id="ordering" name="ordering" placeholder="Nhập vị trí" class="form-control" value="{{ old('ordering') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập vị trí.')" oninput="setCustomValidity('')">
                  @if( $errors->has('ordering') )
                    <div class="alert alert-danger">{{ $errors->first('ordering') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="description">Mô Tả</label>
                  <textarea id="description" name="description" class="form-control" rows="4"></textarea>
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-md-6">
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
                  <input type="text" id="seo_title" name="seo_title" placeholder="Nhập Seo tiêu đề" class="form-control" value="{{ old('seo_title') }}">
                </div>

                <div class="form-group">
                  <label for="seo_keyword">SEO Từ Khóa</label>
                  <input type="text" id="seo_keyword" name="seo_keyword" placeholder="Nhập Seo từ khóa" class="form-control" value="{{ old('seo_keyword') }}">
                </div>

                <div class="form-group">
                  <label for="seo_desciption">SEO Mô Tả <span id="seodeserror" class="error alert-danger" ><span class="change-text">Chuẩn SEO</span> <span id="validateseomota"></span>/160 kí tự</span></label>
                  <input type="text" id="seo_desciption" name="seo_desciption" placeholder="Nhập Seo mô tả" class="form-control" value="{{ old('seo_desciption') }}">
                </div>

                <div class="form-group">
                  <label for="seo_google">Thẻ Tiếp Thị Remarketing</label>
                  <input type="text" id="seo_google" name="seo_google" placeholder="Nhập tiếp thị Google" class="form-control" value="{{ old('seo_google') }}">
                </div>

                <div class="form-group">
                  <label for="seo_facebook">Thẻ Pixel Facebook</label>
                  <input type="text" id="seo_facebook" name="seo_facebook" placeholder="Nhập Pixel Facebook" class="form-control" value="{{ old('seo_facebook') }}">
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
			<a href="{{ route('category.index') }}" class="btn btn-secondary">Thoát</a>
          </div>
        </div>
      </form>
       <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection
