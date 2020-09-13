@extends($data->layout)

@section('title')
  {{ $data->title }}
@endsection

@section($data->content)

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Quản Lý Trang Chủ</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang Quản Trị</a></li>
            <li class="breadcrumb-item active">Quản Lý Trang Chủ</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      @php
        $home_default = $data['home_default'];
      @endphp

      @if( $home_default )
        @php

            $related_sliders              = $data['related_sliders'];
            // $related_partners              = $data['related_partners'];
            $related_hots              = $data['related_hots'];
            // $related_hot2s              = $data['related_hot2s'];
            $related_posts              = $data['related_posts'];
            $related_products_hot              = $data['related_products_hot'];
            $related_products_sale      = $data['related_products_sale'];
            $related_endows              = $data['related_endows'];
            // $related_certifies              = $data['related_certifies'];
            // $related_tvs                    = $data['related_tvs'];
            // $related_newspapers                    = $data['related_newspapers'];

            $funfact_number         = json_decode( $home_default->funfact_number );
            $funfact_icon         = json_decode( $home_default->funfact_icon );
            $funfact_description    = json_decode( $home_default->funfact_description );

            $services_name         = json_decode( $home_default->services_name );
            $services_url         = json_decode( $home_default->services_url );
            $services_description    = json_decode( $home_default->services_description );

            $why_title         = json_decode( $home_default->why_title );
            $why_icon         = json_decode( $home_default->why_icon );
            $why_description    = json_decode( $home_default->why_description );

            $video_hot_title         = json_decode( $home_default->video_hot_title );
            $video_hot_embed         = json_decode( $home_default->video_hot_embed );

            $album_hot_title         = json_decode( $home_default->album_hot_title );
            $album_hot_images         = json_decode( $home_default->album_hot_images );
            $album_hot_alt_images     = json_decode( $home_default->album_hot_alt_images );
        @endphp

        <form role="form" action="{{ route('homepageManager.update',$home_default->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" value="{{ $home_default->id }}">
          <input type="hidden" name="home_default" value="1">

          <div class="form-group">
            <label for="title">Tiêu Đề Quản Lý Trang Chủ</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">@</span>
              </div>
              <input type="text" id="title" name="title" value="{{ $home_default->title ?? old('title') }}" class="form-control" placeholder="Tiêu Đề Quản Lý Trang Chủ" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề quản lý trang chủ.')" oninput="setCustomValidity('')">
            </div>
            @if( $errors->has('title') )
              <div class="alert alert-danger">{{ $errors->first('title') }}</div>
            @endif
          </div>

          @include('backend.inc-dashboard.slider')
          @include('backend.inc-dashboard.counter')
          @include('backend.inc-dashboard.about')
          @include('backend.inc-dashboard.why')
          @include('backend.inc-dashboard.service')
          @include('backend.inc-dashboard.hot')
          {{-- @include('backend.inc-dashboard.hot-2') --}}
          @include('backend.inc-dashboard.product-hot')
          @include('backend.inc-dashboard.product-sale')
          {{-- @include('backend.inc-dashboard.post-hot') --}}
          @include('backend.inc-dashboard.video-hot')
          @include('backend.inc-dashboard.album-hot')
          @include('backend.inc-dashboard.feedback')
          @include('backend.inc-dashboard.endow')
          {{-- @include('backend.inc-dashboard.certify') --}}
          {{-- @include('backend.inc-dashboard.tv') --}}
          {{-- @include('backend.inc-dashboard.newspaper') --}}
          {{-- @include('backend.inc-dashboard.partner') --}}

          <div class="row">
            <div class="col-12">
              <a href="/admin" class="btn btn-secondary hide">Thoát</a>
              <input type="submit" value="Lưu" class="btn btn-success float-right">
            </div>
          </div>
        </form>
        <!-- /.form -->

      @endif

    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <!-- Clone -->
  @include('backend.includes.clone-funfact')
  @include('backend.includes.clone-why')
@endsection
