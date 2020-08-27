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
      $homepageManager        = $data['homepageManager'];
      $related_sliders        = $data['related_sliders'];
      $related_posts_service  = $data['related_posts_service'];
	  $related_products_hot  	  = $data['related_products_hot'];
	  $related_products_sale  	  = $data['related_products_sale'];
	  $related_products_selling   = $data['related_products_selling'];
      $related_galleries      = $data['related_galleries'];
      $related_teams          = $data['related_teams'];
      $related_posts          = $data['related_posts'];
      $related_partners       = $data['related_partners'];

      $funfact_number         = json_decode( $homepageManager->funfact_number );
      $funfact_icon         = json_decode( $homepageManager->funfact_icon );
      $funfact_description    = json_decode( $homepageManager->funfact_description );

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
    @endphp

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <form role="form" action="{{ route('homepageManager.update',$homepageManager->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" value="{{ $homepageManager->id }}">

          <div class="form-group">
            <label for="title">Tiêu Đề Quản Lý Trang Chủ</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">@</span>
              </div>
              <input type="text" id="title" name="title" value="{{ $homepageManager->title ?? old('title') }}" class="form-control" placeholder="Tiêu Đề Quản Lý Trang Chủ" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề quản lý trang chủ.')" oninput="setCustomValidity('')">
            </div>
            @if( $errors->has('title') )
              <div class="alert alert-danger">{{ $errors->first('title') }}</div>
            @endif
          </div>

          @include('backend.pages.homepageManager.inc-update.slider')

          @include('backend.pages.homepageManager.inc-update.about')

          @include('backend.pages.homepageManager.inc-update.service')

		  @include('backend.pages.homepageManager.inc-update.product-sale')

		  @include('backend.pages.homepageManager.inc-update.product-hot')

		  @include('backend.pages.homepageManager.inc-update.product-selling')

          @include('backend.pages.homepageManager.inc-update.counter')

          @include('backend.pages.homepageManager.inc-update.gallery')

          {{-- @include('backend.pages.homepageManager.inc-update.team') --}}

          @include('backend.pages.homepageManager.inc-update.feedback')

          @include('backend.pages.homepageManager.inc-update.news-hot')

          @include('backend.pages.homepageManager.inc-update.partner')

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
