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
      $categories = $data['category'];
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
                        Tên danh mục
                      </th>
                      <th>
                        Loại danh mục
                      </th>
                      <th>
                        Danh mục cha
                      </th>
                      <th>
                        Icon
                      </th>
                      <th>
                        Danh mục nổi bật
                      </th>
                      <th>
                        Hiển thị ở menu
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>

                  @foreach($categories as $key => $category)
                    @php
                      $category_type = '';
                      switch( $category->type ) {
                        case 2:
                          $category_type = 'Liên hệ';
                          break;
                        case 3:
                          $category_type = 'Bài viết đơn';
                          break;
                        case 4:
                          $category_type = 'Bộ sưu tập';
                          break;
                        case 5:
                          $category_type = 'Sản phẩm';
                          break;
                        case 6:
                          $category_type = 'LandingPage';
                          break;
                        default :
                          $category_type = 'Danh mục bài viết';
                          break;
                      }
                    @endphp
                    <tr>
                      <td> {{ ($key + 1) }} </td>
                      <td>
                        <a href="{{ route('category.edit',$category->id) }}"> {{ $category->title }} </a>
                      </td>
                      <td>
                        {!! $category_type !!}
                      </td>
                      <td>
                        {{ $category->Parentname }}
                      </td>
                      <td class="text-center">
                        <a class="{{ $category->icons }}" ></a>
                      </td>
                      <td class="text-center">
                        <input class="switch_element_ajax" type="checkbox" name="is_feature" @if( !empty( $category->is_feature ) && $category->is_feature == '1' ) checked @endif data-bootstrap-switch data-on-text="Bật" data-off-text="Tắt" data-off-color="danger" data-on-color="success" data-url="{{ route('category_is_feature', $category->id) }}">
                      </td>
                      <td class="text-center">
                        <input class="switch_element_ajax" type="checkbox" name="is_show_menu_main" @if( !empty( $category->is_show_menu_main ) && $category->is_show_menu_main == '1' ) checked @endif data-bootstrap-switch data-on-text="Bật" data-off-text="Tắt" data-off-color="danger" data-on-color="success" data-url="{{ route('category_is_show_menu_main', $category->id) }}">
                      </td>
                      <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm hide" href="{{ route('category.show',$category->id) }}">
                          <i class="fas fa-folder"></i> Xem
                        </a>
                        <a class="btn btn-info btn-sm" href="{{ route('category.edit',$category->id) }}">
                          <i class="fas fa-pencil-alt"></i> Sửa
                        </a>
                        <button type="button" class="btn btn-danger btn-sm deleteItemModal" data-toggle="modal" data-target="#modal-danger-delete" data-id="{{ $category->id }}" data-url="admin/category/{{ $category->id }}">
                          <i class="fas fa-trash"></i> Xóa
                        </button>
                        <a class="btn btn-danger btn-sm hide" href="{{route('category_delete',$category->id) }}">
                          <i class="fas fa-trash"></i> Xóa
                        </a>
                        <form action="{{ route('category_delete',$category->id) }}" method="POST" class="hide">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                              Xóa
                          </button>
                        </form>
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
              {{ $categories->appends( request()->query() )->links() }}
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
