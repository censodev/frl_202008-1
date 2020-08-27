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

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ $data->title }}</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 1%">
                        STT
                      </th>
                      <th>
                        Hình
                      </th>
                      <th>
                        Tên Social
                      </th>
                      <th>
                        Ngày
                      </th>
                      <th>
                        Ip
                      </th>
                      <th>
                        Số lần Click
                      </th>
                  </tr>
              </thead>
              <tbody>

                  @foreach($data['socialClicks'] as $key => $socialClick)
                    @php
                      $images = $socialClick->images ?? asset('assets/admin/dist/img/no_image.png');
                      $date   = !empty( $socialClick->date ) ? date_format( date_create( $socialClick->date ),"d/m/Y") : "";
                    @endphp
                    <tr>
                      <td> {{ ($key + 1) }} </td>
                      <td> <img style="width:85px; margin: 0 auto" src="{{ $images }}"> </td>
                      <td>
                        {{ $socialClick->title }}
                      </td>
                      <td>
                        {{ $date }}
                      </td>
                      <td>
                        {{ $socialClick->ip }}
                      </td>
                      <td>
                        {{ $socialClick->number_click }}
                      </td>
                    </tr>
                  @endforeach

              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection