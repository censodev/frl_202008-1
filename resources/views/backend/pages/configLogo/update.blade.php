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
      $configLogo     = $data['configLogo'];
    @endphp

    <!-- Main content -->
    <section class="content">
      <form role="form" action="{{ route('configLogo.update',$configLogo->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $configLogo->id }}">
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
                  <label for="title">Tên Logo</label>
                  <input type="text" id="title" name="title" value="{{ $configLogo->title ?? old('title') }}" class="form-control" required placeholder="Nhập tên logo" oninvalid="this.setCustomValidity('Vui lòng nhập tên logo.')" oninput="setCustomValidity('')">
                  @if( $errors->has('title') )
                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                  @endif
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alias">Đường Dẫn</label>
                      <input type="text" id="link" name="link" value="{{ $configLogo->link ?? old('link') }}" class="form-control" placeholder="Nhập đường dẫn">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alias">Tiêu Đề Đường Dẫn</label>
                      <input type="text" id="link_title" name="link_title" value="{{ $configLogo->link_title ?? old('link_title') }}" class="form-control" placeholder="Nhập tiêu đề đường dẫn">
                    </div>
                  </div>
                </div>

                <div id="holder" class="thumbnail text-center">
                  @if( !empty( $configLogo->images ) )
                    <img src="{{ $configLogo->images }}" style="height: 5rem;">
                  @endif
                </div>
                <div class="input-group">
                  <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Chọn Logo
                    </a>
                  </span>
                  <input id="thumbnail" class="form-control" type="text" name="images" value="{{ $configLogo->images }}" required oninvalid="this.setCustomValidity('Vui lòng chọn logo.')" oninput="setCustomValidity('')">
                </div>
                @if( $errors->has('images') )
                  <div class="alert alert-danger">{{ $errors->first('images') }}</div>
                @endif

                <div class="row mt-1rem">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title_image">Tiêu Đề Hình Ảnh</label>
                      <input type="text" id="title_image" name="title_image" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ $configLogo->title_image ?? old('title_image') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề hình ảnh.')" oninput="setCustomValidity('')">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alt_image">Mô Tả Hình Ảnh</label>
                      <input type="text" id="alt_image" name="alt_image" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ $configLogo->alt_image ?? old('alt_image') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả hình ảnh.')" oninput="setCustomValidity('')">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="category_id">Chọn Loại Logo</label>
                  <select class="form-control custom-select" name="type">
                    <option selected disabled>--- Chọn Loại Logo ---</option>
                    <option value="1" @if( $configLogo->type == 1 ) selected @endif >Top Header</option>
                    <option value="2" @if( $configLogo->type == 2 ) selected @endif >Footer</option>
					<option value="3" @if( $configLogo->type == 3 ) selected @endif >Favicon</option>
                  </select>
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <div class="row">
          <div class="col-12">
            <a href="{{ route('configLogo.index') }}" class="btn btn-secondary">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection
