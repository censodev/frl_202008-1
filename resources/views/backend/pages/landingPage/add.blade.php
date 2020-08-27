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
                    @endphp
                </select>
            </div>
            <div id="holder" class="thumbnail text-center">
            </div>
            <div class="input-group">
              <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Chọn Ảnh Đại Diện
                </a>
              </span>
                <input id="thumbnail" class="form-control" type="text" name="images" value="">
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
            <div class="form-group">
                <label for="seo_title">SEO Tiêu Đề <span id="seotitleerror" class="error alert-danger"><span class="change-text">Chuẩn SEO</span> <span id="validatetitleseo"> </span>/60 kí tự</span></label>
                <input type="text" id="seo_title" name="seo_title" placeholder="Nhập Seo tiêu đề" class="form-control" value="{{ old('seo_title') }}">
            </div>
            <div class="form-group">
                <label for="seo_desciption">SEO Mô Tả <span id="seodeserror" class="error alert-danger" ><span class="change-text">Chuẩn SEO</span> <span id="validateseomota"></span>/160 kí tự</span></label>
                <input type="text" id="seo_desciption" name="seo_desciption" placeholder="Nhập Seo mô tả" class="form-control" value="{{ old('seo_desciption') }}">
            </div>
            <div class="form-group">
                <label for="seo_keyword">SEO Từ Khóa</label>
                <input type="text" id="seo_keyword" name="seo_keyword" placeholder="Nhập Seo từ khóa" class="form-control" value="{{ old('seo_keyword') }}">
            </div>


          @include('backend.pages.landingPage.inc-add.slider')

          @include('backend.pages.landingPage.inc-add.about')

          @include('backend.pages.landingPage.inc-add.service')

		  @include('backend.pages.landingPage.inc-add.why')

          @include('backend.pages.landingPage.inc-add.counter')

          @include('backend.pages.landingPage.inc-add.feedback')

          @include('backend.pages.landingPage.inc-add.partner')

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

    @include('backend.includes.clone-funfact')
    @include('backend.includes.clone-why')

@endsection
