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
      <form role="form" action="{{ route('endow.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                  <label for="name">Tên Ưu Đãi</label>
                  <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required placeholder="Nhập tên Ưu Đãi" oninvalid="this.setCustomValidity('Vui lòng nhập tên Ưu Đãi.')" oninput="setCustomValidity('')">
                  @if( $errors->has('name') )
                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label>Icon</label>
                  <input type="text" name="icon" placeholder="Nhập icon" class="form-control" value="{{ old('icon') }}">
                </div>

              <div class="form-group">
                  <label for="description">Mô Tả</label>
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
            <a href="{{ route('endow.index') }}" class="btn btn-secondary">Thoát</a>
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection
