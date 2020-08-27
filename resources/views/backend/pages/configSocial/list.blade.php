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
      $configSocials = $data['configSocials'];
    @endphp

    <!-- Main content -->
    <section class="content">

      @include('backend.includes.search-form')
	  
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
                        Đường dẫn
                      </th>
                      <th>
                        Ẩn Social
                      </th>
                      <th>
                        Số lần Click
                      </th>
                      <th>
                        Xem lịch sử Click
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>

                  @foreach($configSocials as $key => $configSocial)
                    @php
                      $images = $configSocial->images ?? asset('assets/admin/dist/img/no_image.png');
                    @endphp
                    <tr>
                      <td> {{ ($key + 1) }} </td>
                      <td> <img style="width:85px; margin: 0 auto" src="{{ $images }}"> </td>
                      <td>
                        <a href="{{ route('configSocial.edit',$configSocial->id) }}"> {{ $configSocial->title }} </a>
                      </td>
                      <td>
                        {{ $configSocial->link }}
                      </td>
                      <td>
                        <input class="switch_element_ajax" type="checkbox" name="hide_social" @if( !empty( $configSocial->hide_social ) && $configSocial->hide_social == '1' ) checked @endif data-bootstrap-switch data-on-text="Bật" data-off-text="Tắt" data-off-color="danger" data-on-color="success" data-url="{{ route('social_hide_social', $configSocial->id) }}">
                      </td>
                      <td>
                        {{ $configSocial->Click }}
                      </td>
                      <td>
                        <a class="btn btn-info btn-sm" href="{{ route('social_view_click',$configSocial->id) }}" target="_blank">
                          <i class="fas fa-pencil-alt"></i> Xem
                        </a>
                      </td>
                      <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ route('configSocial.edit',$configSocial->id) }}">
                          <i class="fas fa-pencil-alt"></i> Sửa
                        </a>
                        <button type="button" class="btn btn-danger btn-sm deleteItemModal" data-toggle="modal" data-target="#modal-danger-delete" data-id="{{ $configSocial->id }}" data-url="admin/configSocial/{{ $configSocial->id }}">
                          <i class="fas fa-trash"></i> Xóa
                        </button>
                    </td>
                    </tr>
                  @endforeach

              </tbody>
          </table>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
              {{ $configSocials->appends( request()->query() )->links() }}
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection