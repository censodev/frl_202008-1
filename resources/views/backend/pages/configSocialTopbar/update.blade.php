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
      $configSocialTopbar     = $data['configSocialTopbar'];
    @endphp

    <!-- Main content -->
    <section class="content">
      <form role="form" action="{{ route('configSocialTopbar.update',$configSocialTopbar->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $configSocialTopbar->id }}">
        <div class="row">

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
                  <label for="title">Tên Social</label>
                  <input type="text" id="title" name="title" value="{{ $configSocialTopbar->title ?? old('title') }}" class="form-control" required placeholder="Nhập tên social" oninvalid="this.setCustomValidity('Vui lòng nhập tên social.')" oninput="setCustomValidity('')">
                  @if( $errors->has('title') )
                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="link">Đường dẫn</label>
                  <input type="text" id="link" name="link" value="{{ $configSocialTopbar->link ?? old('link') }}" class="form-control" placeholder="Nhập đường dẫn">
                </div>

                <div class="form-group">
                  <label for="icon">Icon</label>
                  <input type="text" id="icon" name="icon" value="{{ $configSocialTopbar->icon ?? old('icon') }}" class="form-control" required placeholder="Nhập icon" oninvalid="this.setCustomValidity('Vui lòng nhập icon.')" oninput="setCustomValidity('')">
                  @if( $errors->has('icon') )
                    <div class="alert alert-danger">{{ $errors->first('icon') }}</div>
                  @endif
                </div>
                <div id="holder" class="thumbnail text-center"></div>
                <div class="input-group">
                  <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Chọn Ảnh Đại Diện
                    </a>
                  </span>
                  <input id="thumbnail" class="form-control"  value="{{ $configSocialTopbar->image ?? old('image') }}" type="text" name="image">
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <div class="row">
          <div class="col-12">
            <a href="{{ route('configSocialTopbar.index') }}" class="btn btn-secondary">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection