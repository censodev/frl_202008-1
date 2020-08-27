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
      $user     = $data['user'];
      $birthday = !empty( $user->birthday ) ? date_format( date_create( $user->birthday ),"d/m/Y") : "";
    @endphp

    <!-- Main content -->
    <section class="content">
      <form role="form" action="{{ route('user.update',$user->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $user->id }}">
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
                  <label for="name">Tên Đăng Nhập</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">@</span>
                    </div>
                    <input type="text" id="name" name="name" value="{{ $user->name ?? old('name') }}" class="form-control" required placeholder="Nhập tên đăng nhập" oninvalid="this.setCustomValidity('Vui lòng nhập tên đăng nhập.')" oninput="setCustomValidity('')">
                  </div>
                  @if( $errors->has('name') )
                    <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                  @endif
                </div>

                <div id="holder" class="thumbnail text-center">
                  @if( !empty( $user->avatar ) )
                    <img src="{{ $user->avatar }}" style="height: 5rem;">
                  @endif
                </div>
                <div class="input-group">
                  <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i> Chọn Avatar
                    </a>
                  </span>
                  <input id="thumbnail" class="form-control" type="text" name="avatar" value="{{ $user->avatar }}" readonly>
                </div>

                <div class="form-group mt-1rem">
                  <label for="fullname">Họ Và Tên</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">@</span>
                    </div>
                    <input type="text" id="fullname" name="fullname" value="{{ $user->fullname ?? old('fullname') }}" class="form-control" required placeholder="Nhập họ và tên" oninvalid="this.setCustomValidity('Vui lòng nhập họ và tên.')" oninput="setCustomValidity('')">
                  </div>
                  @if( $errors->has('fullname') )
                    <div class="alert alert-danger">{{ $errors->first('fullname') }}</div>
                  @endif
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" id="email" name="email" value="{{ $user->email ?? old('email') }}" class="form-control" placeholder="Nhập Email">
                      </div>
                      @if( $errors->has('email') )
                        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Số điện thoại</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" id="phone" name="phone" value="{{ $user->phone ?? old('phone') }}" class="form-control" placeholder="Nhập số điện thoại">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label for="password">Mật Khẩu</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                    </div>
                    <input type="text" id="password" name="password" value="" class="form-control" placeholder="Nhập mật khẩu">
                  </div>
                  @if( $errors->has('password') )
                    <div class="alert alert-danger">{{ $errors->first('password') }}</div>
                  @endif
                </div>

                <div class="form-group">
                  <label for="address">Địa chỉ</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" id="address" name="address" value="{{ $user->address ?? old('address') }}" class="form-control" placeholder="Nhập địa chỉ">
                  </div>
                </div>

                <div class="form-group">
                  <label for="birthday">Ngày sinh</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" name="birthday" value="{{ $birthday ?? old('birthday') }}" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
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
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection