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
      <form role="form" action="{{ route('schema_post.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <input type="radio" name="status" value="1">
                          <label>Bật</label><br>
                          <input type="radio" name="status" value="0">
                          <label>Tắt</label><br>
                      </div>
                      <div class="form-group">
                          <label for="type">Chọn Bài Viết</label>
                          <select class="form-control" name="id_post" required oninvalid="this.setCustomValidity('Vui lòng chọn bài viết.')" oninput="setCustomValidity('')">
                              <option disabled>--- Lựa Chọn ---</option>
                              @foreach($data['list_post'] as $key => $post)
                                  <option value="{{ $post->id }}"> {{ $post->title }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="url">Url</label>
                          <input type="text" name="url" value="{{ old('url') }}" class="form-control" required placeholder="Nhập url" oninvalid="this.setCustomValidity('Vui lòng nhập url.')" oninput="setCustomValidity('')">
                      </div>
                      <div class="form-group">
                          <label for="headline">Headline</label>
                          <input type="text" name="headline" value="{{ old('headline') }}" class="form-control" required placeholder="Nhập headline" oninvalid="this.setCustomValidity('Vui lòng nhập headline.')" oninput="setCustomValidity('')">
                      </div>
                      <div class="form-group">
                          <label for="datePublished">Ngày đăng</label>
                          <input type="text" name="datePublished" value="{{ old('datePublished') }}" class="form-control form_datetime" required placeholder="Nhập ngày đăng" oninvalid="this.setCustomValidity('Vui lòng nhập ngày đăng.')" oninput="setCustomValidity('')">
                      </div>
                      <div class="form-group">
                          <label for="dateModified">Ngày sửa</label>
                          <input type="text" name="dateModified" value="{{ old('dateModified') }}" class="form-control form_datetime" required placeholder="Nhập ngày sửa" oninvalid="this.setCustomValidity('Vui lòng nhập ngày sửa.')" oninput="setCustomValidity('')">
                      </div>
                      <div class="form-group">
                          <label for="author_name">Tác giả</label>
                          <input type="text" name="author_name" value="{{ old('author_name') }}" class="form-control" placeholder="Nhập tác giả" required oninvalid="this.setCustomValidity('Vui lòng nhập tác giả.')" oninput="setCustomValidity('')">
                      </div>
                      <div class="form-group">
                          <label for="publisher_name">Nhà xuất bản</label>
                          <input type="text" name="publisher_name" value="{{ old('publisher_name') }}" class="form-control" placeholder="Nhập nhà xuất bản" required oninvalid="this.setCustomValidity('Vui lòng nhập nhà xuất bản.')" oninput="setCustomValidity('')">
                      </div>
                      <div id="holder" class="thumbnail text-center">
                      </div>
                      <div class="input-group">
                          <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                              <i class="fa fa-picture-o"></i> Logo Nhà Xuất Bản
                            </a>
                          </span>
                          <input id="thumbnail" class="form-control" type="text" name="publisher_logo" required value="{{ old('publisher_logo') }}">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="row">
                          <div class="card-body pb-0">
                              <div class="row d-flex align-items-stretch increment-thumbnail">
                                   <div class="col-md-12 d-flex align-items-stretch">
                                      <div class="card bg-light box-image-chema">
                                          <div class="card-header text-muted border-bottom-0">
                                              Hình Ảnh
                                          </div>
                                          <div class="card-body pt-0">
                                              <div class="form-group">
                                                  <div id="holder" class="thumbnail text-center">
                                                      <img src="" style="height: 5rem;">
                                                  </div>
                                                  <div class="input-group">
                                                        <span class="input-group-btn">
                                                          <a data-input="thumbnail" data-preview="holder" class="lfm-mul btn btn-primary">
                                                            <i class="fa fa-picture-o"></i> Chọn Ảnh
                                                          </a>
                                                        </span>
                                                      <input id="thumbnail" value="" class="form-control" type="text" name="images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group text-right">
                                  <button class="btn-clone-thumbnail btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Hình Ảnh</button>
                              </div>
                          </div>
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
          <div class="card-body text-center">
            <button type="submit" name="save_and_exits" value="1" class="btn btn-success" role="button">
              Lưu Và Thoát
            </button>
            <button type="submit" name="save_and_exits" value="2" class="btn btn-success" role="button">
              Lưu
            </button>
            <a href="{{ route('schema_post.index') }}" class="btn btn-secondary">Thoát</a>
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
    @include('backend.includes.clone-image-schema')
@endsection
