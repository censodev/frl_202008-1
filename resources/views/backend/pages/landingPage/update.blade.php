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
        $landingPage        = $data['landingPage'];
        $related_sliders        = $data['related_sliders'];
        $related_posts_service  = $data['related_posts_service'];
        $related_products_hot  	  = $data['related_products_hot'];
        $related_products_sale  	  = $data['related_products_sale'];
        $related_products_selling   = $data['related_products_selling'];
        $related_galleries      = $data['related_galleries'];
        $related_teams          = $data['related_teams'];
        $related_posts          = $data['related_posts'];
        $related_partners       = $data['related_partners'];

        $funfact_number         = json_decode( $landingPage->funfact_number );
        $funfact_icon         = json_decode( $landingPage->funfact_icon );
        $funfact_description    = json_decode( $landingPage->funfact_description );

        $count_funfact_number = $count_funfact_icon = $count_funfact_description = 0;
        if( !empty( $funfact_number ) && count( $funfact_number ) > 0 ) {
          $count_funfact_number = count( $funfact_number );
        }

        if( !empty( $funfact_icon ) && count( $funfact_icon ) > 0 ) {
          $count_funfact_icon = count( $funfact_icon );
        }

        if( !empty( $funfact_description ) && count( $funfact_description ) > 0 ) {
          $count_funfact_description = count( $funfact_description );
        }
        $count_funfact = max($count_funfact_number, $count_funfact_icon, $count_funfact_description);

        $why_title          = json_decode( $landingPage->why_title );
          $why_icon           = json_decode( $landingPage->why_icon );
          $why_description    = json_decode( $landingPage->why_description );

          $count_why_title = $count_why_icon = $count_why_description = 0;
          if( !empty( $why_title ) && count( $why_title ) > 0 ) {
            $count_why_title = count( $why_title );
          }

          if( !empty( $why_icon ) && count( $why_icon ) > 0 ) {
            $count_why_icon = count( $why_icon );
          }

          if( !empty( $why_description ) && count( $why_description ) > 0 ) {
            $count_why_description = count( $why_description );
          }

          $count_why = max($count_why_title, $count_why_icon, $count_why_description);

        $landingPage = $data['landingPage'];
    @endphp

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form role="form" action="{{ route('landingPage.update',$landingPage->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" value="{{ $landingPage->id }}">

          <div class="form-group">
            <label for="title">Tiêu Đề Quản Lý Trang Chủ</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">@</span>
              </div>
              <input type="text" id="title" name="title" value="{{ $landingPage->title ?? old('title') }}" class="form-control" placeholder="Tiêu Đề Quản Lý Trang Chủ" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề quản lý trang chủ.')" oninput="setCustomValidity('')">
            </div>
            @if( $errors->has('title') )
              <div class="alert alert-danger">{{ $errors->first('title') }}</div>
            @endif
          </div>

        <div class="form-group">
            <label for="alias">Đường Dẫn Thân Thiện</label>
            <input type="text" id="alias" name="alias" value="{{ $landingPage->alias ?? old('alias') }}" class="form-control" required placeholder="Nhập đường dẫn thân thiện" oninvalid="this.setCustomValidity('Vui lòng nhập đường dẫn thân thiện.')" oninput="setCustomValidity('')">
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
                    showListCategory($category_level,$level, $landingPage->category_id);
                @endphp
            </select>
        </div>
        <div id="holder" class="thumbnail text-center">
            @if( !empty( $landingPage->images ) )
                <img src="{{ $landingPage->images }}" style="height: 5rem;">
            @endif
        </div>
        <div class="input-group">
              <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Chọn Ảnh Đại Diện
                </a>
              </span>
            <input id="thumbnail" class="form-control" type="text" name="images" value="{{ $landingPage->images }}">
        </div>

        <div class="row mt-1rem">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title_image">Tiêu Đề Hình Ảnh</label>
                    <input type="text" id="title_image" name="title_image" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ $landingPage->title_image ?? old('title_image') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="alt_image">Mô Tả Hình Ảnh</label>
                    <input type="text" id="alt_image" name="alt_image" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ $landingPage->alt_image ?? old('alt_image') }}">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="seo_title">SEO Tiêu Đề <span id="seotitleerror" class="error alert-danger"><span class="change-text">Chuẩn SEO</span> <span id="validatetitleseo"> </span>/60 kí tự</span></label>
            <input type="text" id="seo_title" name="seo_title" placeholder="Nhập Seo tiêu đề" class="form-control" value="{{ $landingPage->seo_title ?? old('seo_title') }}">
        </div>
        <div class="form-group">
            <label for="seo_desciption">SEO Mô Tả <span id="seodeserror" class="error alert-danger" ><span class="change-text">Chuẩn SEO</span> <span id="validateseomota"></span>/160 kí tự</span></label>
            <input type="text" id="seo_desciption" name="seo_desciption" placeholder="Nhập Seo mô tả" class="form-control" value="{{ $landingPage->seo_desciption ?? old('seo_desciption') }}">
        </div>
        <div class="form-group">
            <label for="seo_keyword">SEO Từ Khóa</label>
            <input type="text" id="seo_keyword" name="seo_keyword" placeholder="Nhập Seo từ khóa" class="form-control" value="{{ $landingPage->seo_keyword ?? old('seo_keyword') }}">
        </div>

            @include('backend.pages.landingPage.inc-update.slider')

            @include('backend.pages.landingPage.inc-update.about')

            @include('backend.pages.landingPage.inc-update.service')

            @include('backend.pages.landingPage.inc-update.why')

            @include('backend.pages.landingPage.inc-update.counter')

            @include('backend.pages.landingPage.inc-update.feedback')

            @include('backend.pages.landingPage.inc-update.partner')

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
