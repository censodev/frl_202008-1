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
      <form role="form" action="{{ route('configContact.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                  <label for="title">Tiêu đề</label>
                  <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" required placeholder="Nhập tiêu đề" oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                  @if( $errors->has('title') )
                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="google_map">Google Map</label>
                  <textarea id="google_map" name="google_map" class="form-control ckeditor-lfm" rows="4"></textarea>
                </div>

                <div id="holder" class="thumbnail text-center"></div>
                <div class="input-group">
                  <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Chọn hình nền
                    </a>
                  </span>
                  <input id="thumbnail" class="form-control" type="text" name="images_background" readonly>
                </div>

                <div class="form-group mt-1rem">
                  <label for="title_contact">Tiêu đề Form</label>
                  <input type="text" id="title_contact" name="title_contact" value="{{ old('title_contact') }}" class="form-control" placeholder="Nhập tiêu đề Form">
                </div>

                <div class="form-group">
                  <label for="description">Mô tả Form</label>
                  <textarea id="description" name="description" class="form-control ckeditor-lfm" rows="4"></textarea>
                </div>

                <div class="form-group mt-1rem">
                  <label for="title_contact_info">Tiêu đề thông tin chi tiết</label>
                  <input type="text" id="title_contact_info" name="title_contact_info" value="{{ old('title_contact_info') }}" class="form-control" placeholder="Nhập tiêu đề">
                </div>

                <div class="form-group">
                  <label for="description_info">Mô tả thông tin chi tiết</label>
                  <textarea id="description_info" name="description_info" class="form-control ckeditor-lfm" rows="4"></textarea>
                </div>

                <div class="form-group">
                  <label for="contact_info_address">Địa chỉ</label>
                  <textarea id="contact_info_address" name="contact_info[]" class="form-control ckeditor-lfm" rows="4"></textarea>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_info_email">Email</label>
                      <input type="text" id="contact_info_email" name="contact_info[]" value="" class="form-control" placeholder="Nhập Email">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="contact_info_phone">Số điện thoại</label>
                      <input type="text" id="contact_info_phone" name="contact_info[]" value="" class="form-control" placeholder="Nhập số điện thoại">
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
            <a href="{{ route('configContact.index') }}" class="btn btn-secondary hide">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection