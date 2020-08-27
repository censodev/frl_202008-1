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
      $configScript     = $data['configScript'];
    @endphp

    <!-- Main content -->
    <section class="content">
      <form role="form" action="{{ route('configScript.update',$configScript->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $configScript->id }}">
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
                  <input type="text" id="title" name="title" value="{{ $configScript->title ?? old('title') }}" class="form-control" required placeholder="Nhập tiêu đề" oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                  @if( $errors->has('title') )
                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="script_head">Chèn Script, Style vào trong thẻ head</label>
                  <textarea id="script_head" name="script_head" class="form-control ckeditor-lfm" rows="4">{!! $configScript->script_head !!}</textarea>
                </div>

                <div class="form-group">
                  <label for="script_body">Chèn Script, Style ngay dưới thẻ body</label>
                  <textarea id="script_body" name="script_body" class="form-control ckeditor-lfm" rows="4">{!! $configScript->script_body !!}</textarea>
                </div>

                <div class="form-group">
                  <label for="script_footer">Chèn Script, Style dưới footer</label>
                  <textarea id="script_footer" name="script_footer" class="form-control ckeditor-lfm" rows="4">{!! $configScript->script_footer !!}</textarea>
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <div class="row">
          <div class="col-12">
            <a href="{{ route('configScript.index') }}" class="btn btn-secondary hide">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection