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
      <form role="form" action="{{ route('configEmail.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                  <label for="smtp_title">Tiêu đề gửi mail</label>
                  <input type="text" id="smtp_title" name="smtp_title" value="{{ old('smtp_title') }}" class="form-control" required placeholder="Nhập tiêu đề gửi mail" oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề gửi mail.')" oninput="setCustomValidity('')">
                  @if( $errors->has('smtp_title') )
                    <div class="alert alert-danger">{{ $errors->first('smtp_title') }}</div>
                  @endif
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="smtp_email">Email SMTP</label>
                      <input type="email" id="smtp_email" name="smtp_email" value="{{ old('smtp_email') }}" class="form-control" required placeholder="Nhập email SMTP" oninvalid="this.setCustomValidity('Vui lòng nhập email SMTP.')" oninput="setCustomValidity('')">
                      @if( $errors->has('smtp_email') )
                        <div class="alert alert-danger">{{ $errors->first('smtp_email') }}</div>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="smtp_pass">Mật khẩu SMTP</label>
                      <input type="text" id="smtp_pass" name="smtp_pass" value="{{ old('smtp_pass') }}" class="form-control" required placeholder="Nhập mật khẩu SMTP" oninvalid="this.setCustomValidity('Vui lòng nhập mật khẩu SMTP.')" oninput="setCustomValidity('')">
                      @if( $errors->has('smtp_pass') )
                        <div class="alert alert-danger">{{ $errors->first('smtp_pass') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="smtp_port">Cổng SMTP</label>
                      <input type="number" id="smtp_port" name="smtp_port" value="{{ old('smtp_port') }}" class="form-control" required placeholder="Nhập cổng SMTP" oninvalid="this.setCustomValidity('Vui lòng nhập cổng SMTP.')" oninput="setCustomValidity('')">
                      @if( $errors->has('smtp_port') )
                        <div class="alert alert-danger">{{ $errors->first('smtp_port') }}</div>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="smtp_host">Host SMTP</label>
                      <input type="text" id="smtp_host" name="smtp_host" value="{{ old('smtp_host') }}" class="form-control" required placeholder="Nhập Host SMTP" oninvalid="this.setCustomValidity('Vui lòng nhập Host SMTP.')" oninput="setCustomValidity('')">
                      @if( $errors->has('smtp_host') )
                        <div class="alert alert-danger">{{ $errors->first('smtp_host') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="smtp_content">Nội dung email liên hệ</label>
                  <textarea id="smtp_content" name="smtp_content" class="form-control ckeditor-lfm" rows="4"></textarea>
                </div>

              <div class="form-group">
                  <label for="smtp_content">Nội dung email đơn hàng</label>
                  <textarea id="smtp_content_cart" name="smtp_content_cart" class="form-control ckeditor-lfm" rows="4"></textarea>
              </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>

        <div class="row">
          <div class="col-12">
            <a href="{{ route('configEmail.index') }}" class="btn btn-secondary hide">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection
