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
      $signupOffers = $data['signupOffers'];
    @endphp

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          @if( !empty( $signupOffers ) && count( $signupOffers ) > 0 )
            <div class="row d-flex align-items-stretch">

            @foreach( $signupOffers as $signupOffer )

                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                  <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                      Khách Hàng Liên Hệ
                    </div>
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b>{{ $signupOffer->fullname }}</b></h2>
                          <p class="text-muted text-sm hide"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            @if( !empty( $signupOffer->email ) )
                              <li class="small mt-2"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: {{ $signupOffer->email }}</li>
                            @endif

                            @if( !empty( $signupOffer->phone ) )
                              <li class="mt-2"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: <b>{{ $signupOffer->phone }}</b></li>
                            @endif
                          </ul>
                        </div>
                        <div class="col-5 text-center">
                          <img src="{{ asset('assets/admin/dist/img/avatar5.png') }}" alt="" class="img-circle img-fluid">
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-3">
                          <button type="button" class="btn btn-danger btn-sm deleteItemModal" data-toggle="modal" data-target="#modal-danger-delete" data-id="{{ $signupOffer->id }}" data-url="{{ route('signupOffer.destroy',$signupOffer->id) }}">
                            <i class="fas fa-trash"></i> Xóa
                          </button>
                        </div>
                        @if( !empty( $signupOffer->message ) )
                          <div class="col-md-9 col-sm-9 col-xs-9 text-right">
                            <button class="btn btn-sm btn-primary contact-view-info" type="button" data-toggle="modal" data-target="#modal-lg-show-info" data-id="{{ $signupOffer->id }}" data-url="{{ route('signupOffer.edit',$signupOffer->id) }}">
                              <i class="fas fa-user"></i> Xem Nội Dung Liên Hệ
                            </button>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

              @endforeach

            </div>
          @else
            <div class="form-group">
              <h2 class="text-center">Chưa Có Khách Hàng Đăng Ký Nhận Ưu Đãi.</h2>
            </div>
          @endif
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
              {{ $signupOffers->links() }}
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection