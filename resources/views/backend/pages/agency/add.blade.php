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
      <form role="form" action="{{ route('agency.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                  <div class="col-md-12">
                      <div class="row">
                          <div class="col-xs-12 col-md-4">
                              <div class="form-group">
                                  <label>Tên <span class="maudo"></span></label>
                                  <input type="text" class="form-control" name="name" required="" placeholder="Nhập tên đại lý">
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-4">
                              <div class="form-group">
                                  <label>Mật khẩu<span class="maudo"></span></label>
                                  <input type="text" class="form-control" name="password" required="" placeholder="Nhập mật khẩu">
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-4">
                              <div class="form-group">
                                  <label>Trạng thái</label>
                                  <select class="form-control" name="status">
                                      <option value="1">Kích Hoạt</option>
                                      <option value="0">Ẩn</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12 col-md-6">
                              <div class="form-group">
                                  <label>Điện Thoại<span class="maudo"></span></label>
                                  <input type="text" class="form-control" name="phone" required="" placeholder="Nhập số điện thoại đại lý">
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-6">
                              <div class="form-group">
                                  <label>Email</label>
                                  <input type="text" class="form-control" name="email" required="" placeholder="Nhập email nhà đại lý">
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12 col-md-6">
                              <div class="form-group">
                                  <label>Địa Chỉ<span class="maudo"></span></label>
                                  <input type="text" class="form-control" name="address" required="" placeholder="Nhập địa chỉ nhà đại lý">
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-6">
                              <div class="form-group">
                                  <label>Mã Số Ngân Hàng</label>
                                  <input type="text" class="form-control" name="bank_code" required="" placeholder="Nhập mẫ số ngân hàng">
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12 col-md-6">
                              <div class="form-group">
                                  <label>Mã Số Thuế<span class="maudo"></span></label>
                                  <input type="text" class="form-control" name="tax_code" required="" placeholder="Nhập mã số thuế">
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-6">
                              <div class="form-group">
                                  <label>Tên Người Liên Hệ</label>
                                  <input type="text" class="form-control" name="user_name" required="" placeholder="Nhập tên người liên hệ">
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-xs-12 col-md-6">
                              <div class="form-group">
                                  <label>SDT Người Liên Hệ<span class="maudo"></span></label>
                                  <input type="text" class="form-control" name="user_phone" required="" placeholder="Nhập số điện thoại người liên hệ">
                              </div>
                          </div>
                          <div class="col-xs-12 col-md-6">
                              <div class="form-group">
                                  <label>Ngày Sinh Người Liên Hệ</label>
                                  <input type="date" class="form-control" name="user_date" required="" placeholder="Nhập tên người liên hệ">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
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
            <a href="{{ route('agency.index') }}" class="btn btn-secondary">Thoát</a>
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection
