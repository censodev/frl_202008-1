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
              <li class="breadcrumb-item"><a href="/admin">Trang Quản Trị</a></li>
              <li class="breadcrumb-item active">{{ $data->title }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @php
      $users = $data['users'];
    @endphp

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          @if( !empty( $users ) && count( $users ) > 0 )
            <div class="row d-flex align-items-stretch">

              @foreach( $users as $key => $user )

                @php
                  $avatar   = $user->avatar ?? asset('assets/admin/dist/img/avatar5.png');
                  $birthday = !empty( $user->birthday ) ? date_format( date_create( $user->birthday ),"d/m/Y") : "";
                @endphp

                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                  <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                      Tài Khoản
                    </div>
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b>{{ $user->fullname }}</b></h2>
                          <p class="text-muted text-sm hide"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            @if( !empty( $user->address ) )
                              <li class="mt-2"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Địa chỉ: <b>{{ $user->address }}</b></li>
                            @endif

                            @if( !empty( $user->phone ) )
                              <li class="mt-2"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: <b class="error alert-danger">{{ $user->phone }}</b></li>
                            @endif

                            @if( !empty( $user->email ) )
                              <li class="mt-2"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: <b>{{ $user->email }}</b></li>
                            @endif

                            @if( !empty( $birthday ) )
                              <li class="mt-2"><span class="fa-li"><i class="fas fa-lg fa-birthday-cake"></i></span> Ngày sinh: <b>{{ $birthday }}</b></li>
                            @endif
                          </ul>
                        </div>
                        <div class="col-5 text-center">
                          <img src="{{ $avatar }}" alt="" class="img-circle img-fluid">
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-3">
                          @if( $key != 0 )
                            <button type="button" class="btn btn-danger btn-sm deleteItemModal" data-toggle="modal" data-target="#modal-danger-delete" data-id="{{ $user->id }}" data-url="{{ route('user.destroy',$user->id) }}">
                              <i class="fas fa-trash"></i> Xóa
                            </button>
                          @endif
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-9 text-right">
                          <a href="{{ route('user.edit',$user->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-user"></i> Xem Thông Tin
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              @endforeach

            </div>
          @else
            <div class="form-group">
              <h2 class="text-center">Chưa Có Khách Hàng Nào Liên Hệ.</h2>
            </div>
          @endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer hide">
          <nav aria-label="users Page Navigation">
            <ul class="pagination justify-content-center m-0">
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
              <li class="page-item"><a class="page-link" href="#">5</a></li>
              <li class="page-item"><a class="page-link" href="#">6</a></li>
              <li class="page-item"><a class="page-link" href="#">7</a></li>
              <li class="page-item"><a class="page-link" href="#">8</a></li>
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection