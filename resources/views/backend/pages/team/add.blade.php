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
      <form role="form" action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
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
                  <label for="name">Tên Thành Viên</label>
                  <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required placeholder="Nhập tên thành viên" oninvalid="this.setCustomValidity('Vui lòng nhập tên thành viên.')" oninput="setCustomValidity('')">
                  @if( $errors->has('name') )
                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                  @endif
                </div>

                <div id="holder" class="thumbnail text-center"></div>
                <div class="input-group">
                  <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Chọn Ảnh Đại Diện
                    </a>
                  </span>
                  <input id="thumbnail" class="form-control" type="text" name="images" required oninvalid="this.setCustomValidity('Vui lòng chọn ảnh đại diện.')" oninput="setCustomValidity('')">
                </div>

                <div class="row mt-1rem">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title_image">Tiêu Đề Hình Ảnh</label>
                      <input type="text" id="title_image" name="title_image" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ old('title_image') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề hình ảnh.')" oninput="setCustomValidity('')">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alt_image">Mô Tả Hình Ảnh</label>
                      <input type="text" id="alt_image" name="alt_image" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ old('alt_image') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả hình ảnh.')" oninput="setCustomValidity('')">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="position">Chức Vụ</label>
                      <input type="text" id="position" name="position" placeholder="Nhập Chức Vụ" class="form-control" value="{{ old('position') }}">
                    </div>
                  </div>
                  <div class="col-md-6 hide">
                    <div class="form-group">
                      <label for="social_phone">Số Điện Thoại</label>
                      <input type="text" id="social_phone" name="social[]" placeholder="Nhập Số Điện Thoại" class="form-control" value="">
                    </div>
                  </div>
                </div>

                <div class="row hide">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="social_fb">Facebook</label>
                      <input type="text" id="social_fb" name="social[]" placeholder="Nhập Link Facebook" class="form-control" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="social_tw">Twitter</label>
                      <input type="text" id="social_tw" name="social[]" placeholder="Nhập Link Twitter" class="form-control" value="">
                    </div>
                  </div>
                </div>

                <div class="row hide">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="social_ggpl">Google Plus</label>
                      <input type="text" id="social_ggpl" name="social[]" placeholder="Nhập Link Google Plus" class="form-control" value="">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="social_in">Instagram</label>
                      <input type="text" id="social_in" name="social[]" placeholder="Nhập Link Instagram" class="form-control" value="">
                    </div>
                  </div>
                </div>
				
				<div class="form-group">
                  <label for="description">Mô tả</label>
                  <textarea id="description" name="description" class="form-control" rows="4">{!! old('description') !!}</textarea>
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
            <a href="{{ route('team.index') }}" class="btn btn-secondary">Thoát</a>
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection