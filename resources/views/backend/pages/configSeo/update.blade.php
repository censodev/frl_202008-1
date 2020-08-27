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
      $configSeo     = $data['configSeo'];
    @endphp

    <!-- Main content -->
    <section class="content">
      <form role="form" action="{{ route('configSeo.update',$configSeo->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $configSeo->id }}">
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
                  <input type="text" id="title" name="title" value="{{ $configSeo->title ?? old('title') }}" class="form-control" required placeholder="Nhập tiêu đề" oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                  @if( $errors->has('title') )
                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="seo_title">Tiêu đề Website</label>
                  <input type="text" id="seo_title" name="seo_title" value="{{ $configSeo->seo_title ?? old('seo_title') }}" class="form-control" required placeholder="Nhập tiêu đề" oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                  @if( $errors->has('seo_title') )
                    <div class="alert alert-danger">{{ $errors->first('seo_title') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="seo_description">Mô tả Website</label>
                  <input type="text" id="seo_description" name="seo_description" value="{{ $configSeo->seo_description ?? old('seo_description') }}" class="form-control" placeholder="Nhập mô tả website">
                </div>

                <div class="form-group">
                  <label for="seo_keywords">Từ khóa Seo</label>
                  <input type="text" id="seo_keywords" name="seo_keywords" value="{{ $configSeo->seo_keywords ?? old('seo_keywords') }}" class="form-control" placeholder="Nhập từ khóa Seo">
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <div class="row">
          <div class="col-12">
            <a href="{{ route('configSeo.index') }}" class="btn btn-secondary hide">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection