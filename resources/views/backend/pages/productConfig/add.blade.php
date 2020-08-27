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

    <section class="content">
      <form role="form" action="{{ route('productConfig.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
          {{ csrf_field() }}
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
                      <div class="row d-flex align-items-stretch increment-thumbnail" id="list-option-product">
                          <div class="col-md-12 d-flex align-items-stretch">
                              <div class="card bg-light">
                                  <div class="card-body pt-0">
                                      <div class="row">
                                          <div class="col-md-4">
                                              <label>Kích thước</label>
                                              <select name="size" placeholder="Chọn kích thước" class="form-control">
                                                  <option value="mm">milimet</option>
                                                  <option value="cm">centimet</option>
                                                  <option value="dm">decimet</option>
                                                  <option value="m">met</option>
                                              </select>
                                          </div>
                                          <div class="col-md-4">
                                              <label>Khối lượng</label>
                                              <select name="mass" placeholder="Chọn khối lượng" class="form-control">
                                                  <option value="g">gam</option>
                                                  <option value="kg">kilogame</option>
                                              </select>
                                          </div>
                                          <div class="col-md-4">
                                              <label>Thể tích</label>
                                              <select name="volume" placeholder="Chọn thể tích" class="form-control">
                                                  <option value="mm³">milimet khối</option>
                                                  <option value="cm³">centimet khối</option>
                                                  <option value="dm³">decimet khối</option>
                                                  <option value="m³">met khối</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="row d-flex align-items-stretch increment-color">
                          <div class="col-md-4 d-flex align-items-stretch">
                              <div class="card bg-light">
                                  <div class="card-body pt-0">
                                      <div class="row">
                                          <div class="col-md-9">
                                              <div class="form-group">
                                                  <label>Tên màu</label>
                                                  <input type="text" name="name_color[]" placeholder="Nhập tên màu" class="form-control" value="" required>
                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                              <div class="form-group">
                                                  <label>Mã màu</label>
                                                  <input type="color" name="value_color[]" value="#ff0000" class="form-control" required>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group text-right">
                          <button class="btn-clone-color btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm màu</button>
                      </div>
                  </div>
              </div>
              <!-- /.card-body -->
            </div>
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
            <a href="{{ route('product.index') }}" class="btn btn-secondary">Thoát</a>
          </div>
        </div>
      </form>
    </section>
    @include('backend.includes.clone-product-color')
@endsection
