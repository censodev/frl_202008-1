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
      <form role="form" action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                  <label for="name_customer">Tên Khách Hàng</label>
                  <input type="text" id="name_customer" name="name_customer" value="{{ old('name_customer') }}" class="form-control" required placeholder="Nhập tên khách hàng" oninvalid="this.setCustomValidity('Vui lòng nhập tên khách hàng.')" oninput="setCustomValidity('')">
                  @if( $errors->has('name_customer') )
                    <div class="alert alert-danger">{{ $errors->first('name_customer') }}</div>
                  @endif
                </div>
				
				<div class="form-group">
                  <label for="position">Chức Vụ</label>
                  <input type="text" id="position" name="position" value="{{ old('position') }}" class="form-control" placeholder="Nhập chức vụ">
                </div>

                <div id="holder" class="thumbnail text-center"></div>
                <div class="input-group">
                  <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Chọn Ảnh Đại Diện
                    </a>
                  </span>
                  <input id="thumbnail" class="form-control" type="text" name="images" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                  @if( $errors->has('images') )
                    <div class="alert alert-danger">{{ $errors->first('images') }}</div>
                  @endif
                </div>

                <div class="row mt-1rem">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="title_image">Tiêu Đề Hình Ảnh</label>
                      <input type="text" id="title_image" name="title_image" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ old('title_image') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                      @if( $errors->has('title_image') )
                        <div class="alert alert-danger">{{ $errors->first('title_image') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="alt_image">Mô Tả Hình Ảnh</label>
                      <input type="text" id="alt_image" name="alt_image" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ old('alt_image') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                      @if( $errors->has('alt_image') )
                        <div class="alert alert-danger">{{ $errors->first('alt_image') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="description">Nội Dung Phản Hồi</label>
                  <textarea id="description" name="description" class="form-control" rows="4" required oninvalid="this.setCustomValidity('Vui lòng nhập nội dung phản hồi.')" oninput="setCustomValidity('')"></textarea>
                  @if( $errors->has('description') )
                    <div class="alert alert-danger">{{ $errors->first('description') }}</div>
                  @endif
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <a href="{{ route('feedback.index') }}" class="btn btn-secondary">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection