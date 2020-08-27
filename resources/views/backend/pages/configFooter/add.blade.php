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
      <form role="form" action="{{ route('configFooter.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                  <label for="footer_title_1">Tiêu đề Footer 1</label>
                  <input type="text" id="footer_title_1" name="footer_title[]" value="" class="form-control" placeholder="Nhập tiêu đề">
                </div>

                <div class="form-group">
                  <label for="footer_description_1">Nội dung Footer 1</label>
                  <textarea id="footer_description_1" name="footer_description[]" class="form-control ckeditor-lfm" rows="4"></textarea>
                </div>

                <div class="form-group">
                  <label for="footer_title_2">Tiêu đề Footer 2</label>
                  <input type="text" id="footer_title_2" name="footer_title[]" value="" class="form-control" placeholder="Nhập tiêu đề">
                </div>

                <div class="form-group">
                  <label for="footer_contact_info_ct">Địa chỉ</label>
                  <input type="text" id="footer_contact_info_ct" name="footer_contact_info[]" value="" class="form-control" placeholder="Nhập địa chỉ">
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="footer_contact_info_e">Email</label>
                      <input type="email" id="footer_contact_info_e" name="footer_contact_info[]" value="" class="form-control" placeholder="Nhập Email">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="footer_contact_info_time">Thời gian làm việc</label>
                      <input type="text" id="footer_contact_info_time" name="footer_contact_info[]" value="" class="form-control" placeholder="Nhập thời gian làm việc">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="footer_contact_info_hl">Số Hotline</label>
                      <input type="text" id="footer_contact_info_hl" name="footer_contact_info[]" value="" class="form-control" placeholder="Nhập số Hotline">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="footer_contact_info_phone">Số điện thoại cố định</label>
                      <input type="text" id="footer_contact_info_phone" name="footer_contact_info[]" value="" class="form-control" placeholder="Nhập số điện thoại cố định">
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="footer_description_2">Nội dung Footer 2</label>
                  <textarea id="footer_description_2" name="footer_description[]" class="form-control ckeditor-lfm" rows="4"></textarea>
                </div>

                <div class="form-group">
                  <label for="footer_title_3">Tiêu đề Footer 3</label>
                  <input type="text" id="footer_title_3" name="footer_title[]" value="" class="form-control" placeholder="Nhập tiêu đề">
                </div>

                <div class="form-group">
                  <label for="footer_description_3">Nội dung Footer 3</label>
                  <textarea id="footer_description_3" name="footer_description[]" class="form-control ckeditor-lfm" rows="4"></textarea>
                </div>

                <div class="form-group">
                  <label for="footer_title_4">Tiêu đề Footer 4</label>
                  <input type="text" id="footer_title_4" name="footer_title[]" value="" class="form-control" placeholder="Nhập tiêu đề">
                </div>

                <div class="form-group">
                  <label for="footer_description_4">Nội dung Footer 4</label>
                  <textarea id="footer_description_4" name="footer_description[]" class="form-control ckeditor-lfm" rows="4"></textarea>
                </div>

                <div class="form-group">
                  <label for="footer_copyright">Copyright</label>
                  <textarea id="footer_copyright" name="footer_copyright" class="form-control ckeditor-lfm" rows="4"></textarea>
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>

        <div class="row">
          <div class="col-12">
            <a href="{{ route('configFooter.index') }}" class="btn btn-secondary hide">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection