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
        <form role="form" action="{{ route('homepageManager.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
          @csrf

          <div class="form-group">
            <label for="title">Tiêu Đề Quản Lý Trang Chủ</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">@</span>
              </div>
              <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="Tiêu Đề Quản Lý Trang Chủ" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề quản lý trang chủ.')" oninput="setCustomValidity('')">
            </div>
            @if( $errors->has('title') )
              <div class="alert alert-danger">{{ $errors->first('title') }}</div>
            @endif
          </div>

          @include('backend.pages.homepageManager.inc-add.slider')

          @include('backend.pages.homepageManager.inc-add.about')

          @include('backend.pages.homepageManager.inc-add.service')

		  @include('backend.pages.homepageManager.inc-add.product-sale')

		  @include('backend.pages.homepageManager.inc-add.product-hot')

		  @include('backend.pages.homepageManager.inc-add.product-selling')

          @include('backend.pages.homepageManager.inc-add.counter')

          @include('backend.pages.homepageManager.inc-add.gallery')

          {{-- @include('backend.pages.homepageManager.inc-add.team') --}}

          @include('backend.pages.homepageManager.inc-add.feedback')

          @include('backend.pages.homepageManager.inc-add.news-hot')

          @include('backend.pages.homepageManager.inc-add.partner')

          <div class="row">
            <div class="col-12">
              <a href="{{ route('homepageManager.index') }}" class="btn btn-secondary">Thoát</a>
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

@endsection
