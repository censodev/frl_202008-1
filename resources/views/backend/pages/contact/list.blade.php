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
      $contacts = $data['contacts'];
    @endphp

    <!-- Main content -->
    <section class="content">

      @include('backend.includes.search-form')
	  
	  <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          @if( !empty( $contacts ) && count( $contacts ) > 0 )
            <div class="row d-flex align-items-stretch">

            @foreach( $contacts as $contact )

                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                  <div class="card bg-light">
                    <div class="card-header text-muted border-bottom-0">
                      Khách Hàng Liên Hệ
                    </div>
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b>{{ $contact->fullname }}</b></h2>
                          <p class="text-muted text-sm hide"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            @if( !empty( $contact->address ) )
                              <li class="small mt-2"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Địa chỉ: {{ $contact->address }}</li>
                            @endif

                            @if( !empty( $contact->email ) )
                              <li class="small mt-2"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email: <b>{{ $contact->email }}</b></li>
                            @endif

                            @if( !empty( $contact->phone ) )
                              <li class=" mt-2"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: <b>{{ $contact->phone }}</b></li>
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
                          <button type="button" class="btn btn-danger btn-sm deleteItemModal" data-toggle="modal" data-target="#modal-danger-delete" data-id="{{ $contact->id }}" data-url="{{ route('contact.destroy',$contact->id) }}">
                            <i class="fas fa-trash"></i> Xóa
                          </button>
                        </div>
                        @if( !empty( $contact->message ) )
                          <div class="col-md-9 col-sm-9 col-xs-9 text-right">
                            <button class="btn btn-sm btn-primary contact-view-info" type="button" data-toggle="modal" data-target="#modal-lg-show-info" data-id="{{ $contact->id }}" data-url="{{ route('contact.edit',$contact->id) }}">
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
              <h2 class="text-center">Chưa Có Khách Hàng Nào Liên Hệ.</h2>
            </div>
          @endif
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
              {{ $contacts->appends( request()->query() )->links() }}
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection