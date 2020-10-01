@extends($data->layout)

@section('title')
  {{ $data->title }}
@endsection

@php
    $types = $data['types'];
@endphp

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
      <div class="container-fluid">
        <form role="form" action="{{ route('landingPage.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
          @csrf

          <div class="form-group">
            <label for="title">Tiêu Đề LandingPage</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">@</span>
              </div>
              <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="Tiêu Đề LandingPage" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề LandingPage.')" oninput="setCustomValidity('')">
            </div>
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
                <label for="category_id">Chọn Danh Mục ( Bài Viết )</label>
                <select class="form-control custom-select" name="category_id" required oninvalid="this.setCustomValidity('Vui lòng chọn danh mục cha.')" oninput="setCustomValidity('')">
                    <option selected disabled>--- Chọn Danh Mục ---</option>
                    @php
                        $level = 0;
                        $category_level = $data['category_level']->toArray();
                        showListCategoryPost($category_level,$level);
                    @endphp
                </select>
            </div>
            <div id="holder_landing" class="thumbnail text-center">
            </div>
            <div class="input-group">
              <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail_landing" data-preview="holder_landing" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Chọn Ảnh Đại Diện
                </a>
              </span>
                <input id="thumbnail_landing" class="form-control" type="text" name="image_landing" value="">
            </div>

            <div class="row mt-1rem">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title_image">Tiêu Đề Hình Ảnh</label>
                        <input type="text" name="title_image_landing" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ old('title_image_landing') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="alt_image">Mô Tả Hình Ảnh</label>
                        <input type="text" name="alt_image_landing" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ old('alt_image_landing') }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="seo_title">SEO Tiêu Đề <span id="seotitleerror" class="error alert-danger"><span class="change-text">Chuẩn SEO</span> <span id="validatetitleseo"> </span>/60 kí tự</span></label>
                <input type="text" id="seo_title" name="seo_title" placeholder="Nhập Seo tiêu đề" class="form-control" value="{{ old('seo_title') }}" required>
            </div>
            <div class="form-group">
                <label for="seo_desciption">SEO Mô Tả <span id="seodeserror" class="error alert-danger" ><span class="change-text">Chuẩn SEO</span> <span id="validateseomota"></span>/160 kí tự</span></label>
                <input type="text" id="seo_desciption" name="seo_desciption" placeholder="Nhập Seo mô tả" class="form-control" value="{{ old('seo_desciption') }}" required>
            </div>
            <div class="form-group">
                <label for="seo_keyword">SEO Từ Khóa</label>
                <input type="text" id="seo_keyword" name="seo_keyword" placeholder="Nhập Seo từ khóa" class="form-control" value="{{ old('seo_keyword') }}" required>
            </div>


            <div class="card card-solid">
                <div class="card-header">
                    <h3 class="card-title">Section</h3>
                </div>
                <div class="card-body pb-0">
                    <div class="row d-flex align-items-stretch increment-section">
                        <div class="col-12 col-sm-12 col-md-12 align-items-stretch section-item">
                            <div class="card bg-light">
                                <div class="card-header text-muted border-bottom-0">
                                    Section
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <input type="hidden" value="" name="item_id[]">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tiêu đề</label>
                                                <input type="text" name="name[]" placeholder="Nhập tiêu đề" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Chọn loại modules</label>
                                                <select name="type[]" class="form-control" required>
                                                    <option value="">---chọn loại---</option>
                                                    @foreach($types as $key => $type)
                                                        <option value="{{ $key }}">{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Thứ tự</label>
                                                <input type="number" name="ordering[]" class="form-control" value="">
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6">
                                            <div class="form-group">
                                                <div id="holder" class="thumbnail text-center"></div>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                      <a data-input="thumbnail" data-preview="holder" class="lfm-mul btn btn-primary">
                                                        <i class="fa fa-picture-o"></i> Chọn Ảnh Desktop
                                                      </a>
                                                    </span>
                                                    <input id="thumbnail" class="form-control" type="text" name="images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="title_image">Tiêu Đề Hình Ảnh Desktop</label>
                                                <input type="text" id="title_image" name="title_image[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                            </div>

                                            <div class="form-group">
                                                <label for="alt_image">Mô Tả Hình Ảnh Desktop</label>
                                                <input type="text" id="alt_image" name="alt_image[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div id="holder_mobile" class="thumbnail text-center"></div>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                      <a data-input="thumbnail_mobile" data-preview="holder_mobile" class="lfm-mul btn btn-primary">
                                                        <i class="fa fa-picture-o"></i> Chọn Ảnh Mobile
                                                      </a>
                                                    </span>
                                                    <input id="thumbnail_mobile" class="form-control" type="text" name="images_mobile[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="title_image">Tiêu Đề Hình Ảnh Mobile</label>
                                                <input type="text" name="title_image_mobile[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                            </div>

                                            <div class="form-group">
                                                <label for="alt_image">Mô Tả Hình Ảnh Mobile</label>
                                                <input type="text" name="alt_image_mobile[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                            </div>
                                        </div> --}}
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Chi Tiết</label>
                                                <textarea name="description[]" class="form-control" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tiêu Đề Kêu Gọi Hành Động</label>
                                                <input name="title_action[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Icon Kêu Gọi Hành Động</label>
                                                <input name="icon_action[]" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Số Điện Thoại</label>
                                                <input name="id_action[]" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-12 list-value">
                                            <div class="form-group block-search-appliesto">
                                                <button class="btn btn-info " disabled type="button" data-toggle="modal" data-target="" search="" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
                                            </div>
                                            <div class="form-group">
                                                <ul class="todo-list appliesto-value" data-widget="todo-list">

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12 hide section-service">
                                            @include('backend.inc-dashboard.service')
                                        </div>
                                        <div class="col-md-12 hide table-editor">
                                            <textarea class="ckeditor-lfm" name="table_editor" id="" rows="10">
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn-clone-section btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Section</button>
                    </div>
                </div>
            </div>
          <div class="row">
            <div class="col-12">
              <a href="{{ route('landingPage.index') }}" class="btn btn-secondary">Thoát</a>
              <input type="submit" value="Lưu" class="btn btn-success float-right">
            </div>
          </div>
        </form>
         <!-- /.form -->
      </div>
    </section>
    <!-- /.content -->

    <!-- Clone -->

    @include('backend.includes.clone-section-landing')

@endsection
