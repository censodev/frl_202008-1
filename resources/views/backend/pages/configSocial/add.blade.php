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
      <form role="form" action="{{ route('configSocial.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8" class="form-social">
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
                  <label for="title">Tên Social</label>
                  <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" required placeholder="Nhập tên social" oninvalid="this.setCustomValidity('Vui lòng nhập tên social.')" oninput="setCustomValidity('')">
                  @if( $errors->has('title') )
                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="select_link">Chọn Loại đường dẫn</label>
                  <select class="form-control custom-select" name="select_link">
                    <option value="1">Trực Tiếp ( nhập link vào ô "Đường dẫn" )</option>
                    <option value="2">Facebook ( nhập vào ID FanPage hoặc Facebook vào ô "Đường dẫn" )</option>
                    <option value="3">Zalo ( nhập số điện thoại vào ô "Đường dẫn" )</option>
                    <option value="4">Đăng Ký Form</option>
                    <option value="5">Số Hotline ( nhập số hotline vào ô "Đường dẫn" , mặc định chỉ hiển thị trên mobile )</option>
                    <option value="6">SMS ( nhập số điện thoại vào ô "Đường dẫn" )</option>
                    <option value="7">Google Map ( nhập link map vào ô "Đường dẫn" )</option>
                  </select>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alias">Đường Dẫn</label>
                      <input type="text" id="link" name="link" value="{{ old('link') }}" class="form-control" placeholder="Nhập đường dẫn">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alias">Tiêu Đề Đường Dẫn</label>
                      <input type="text" id="link_title" name="link_title" value="{{ old('link_title') }}" class="form-control" placeholder="Nhập tiêu đề đường dẫn">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <input type="checkbox" name="icon_default" data-bootstrap-switch data-on-text="Bật" data-off-text="Tắt" data-off-color="danger" data-on-color="success">
                  <label for="category_id">Hiển thị Icon mặc định</label>
                </div>

                <div id="holder" class="thumbnail text-center icon_default_hide"></div>
                <div class="input-group icon_default_hide">
                  <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Chọn Hình Ảnh
                    </a>
                  </span>
                  <input id="thumbnail" class="form-control icon-default-required" type="text" name="images" required>
                </div>

                <div class="row mt-1rem icon_default_hide">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title_image">Tiêu Đề Hình Ảnh</label>
                      <input type="text" id="title_image" name="title_image" placeholder="Nhập tiêu đề hình ảnh" class="form-control icon-default-required" value="{{ old('title_image') }}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alt_image">Mô Tả Hình Ảnh</label>
                      <input type="text" id="alt_image" name="alt_image" placeholder="Nhập mô tả hình ảnh" class="form-control icon-default-required" value="{{ old('alt_image') }}" required>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>

        <div class="row">
          <div class="col-12">
            <a href="{{ route('configSocial.index') }}" class="btn btn-secondary">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection