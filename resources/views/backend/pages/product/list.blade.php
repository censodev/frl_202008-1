@extends($data->layout)

@section('title')
  {{ $data->title }}
@endsection

@section($data->content)
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
      $products = $data['products'];
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
                        Hình đại diện
                      </th>
                      <th>
                        Tiêu đề
                      </th>
                      <th>
                        Danh mục
                      </th>
                      <th class="hide">
                        Danh mục nổi bật
                      </th>
                      <th>
                          Sản phẩm mới
                      </th>
                      <th>
                        Sản phẩm nổi bật
                      </th>
					  <th>
                        Sản phẩm khuyến mãi
                      </th>
					  <th>
                        Sản phẩm bán chạy
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>

                  @foreach($products as $key => $product)
                      @php
                          $images         = json_decode( $product->images );
                          $title_image    = json_decode( $product->title_image );
                          $alt_image      = json_decode( $product->alt_image );
                      @endphp
                    <tr>
                      <td> {{ ($key + 1) }} </td>
                      <td> <img style="width:85px; margin: 0 auto" src="{{ $images[0] }}" title="{{ $title_image[0] }}" alt="{{ $alt_image[0] }}"> </td>
                      <td>
                        <a href="{{ route('product.edit',$product->id) }}"> {{ $product->title }} </a>
                      </td>
                      <td>
                        {{ $product->Category }}
                      </td>
                      <td class="text-center hide">
                        <input class="switch_element_ajax" type="checkbox" name="is_cat_feature" @if( !empty( $product->is_cat_feature ) && $product->is_cat_feature == '1' ) checked @endif data-bootstrap-switch data-on-text="Bật" data-off-text="Tắt" data-off-color="danger" data-on-color="success" data-url="{{ route('product_is_cat_feature', $product->id) }}">
                      </td>
                        <td class="text-center">
                            <input class="switch_element_ajax" type="checkbox" name="is_product_new" @if( !empty( $product->is_product_new ) && $product->is_product_new == '1' ) checked @endif data-bootstrap-switch data-on-text="Bật" data-off-text="Tắt" data-off-color="danger" data-on-color="success" data-url="{{ route('product_is_product_new', $product->id) }}">
                        </td>
                      <td class="text-center">
                        <input class="switch_element_ajax" type="checkbox" name="is_product_feature" @if( !empty( $product->is_product_feature ) && $product->is_product_feature == '1' ) checked @endif data-bootstrap-switch data-on-text="Bật" data-off-text="Tắt" data-off-color="danger" data-on-color="success" data-url="{{ route('product_is_product_feature', $product->id) }}">
                      </td>
					  <td class="text-center">
                        <input class="switch_element_ajax" type="checkbox" name="is_product_sale" @if( !empty( $product->is_product_sale ) && $product->is_product_sale == '1' ) checked @endif data-bootstrap-switch data-on-text="Bật" data-off-text="Tắt" data-off-color="danger" data-on-color="success" data-url="{{ route('product_is_product_sale', $product->id) }}">
                      </td>
					  <td class="text-center">
                        <input class="switch_element_ajax" type="checkbox" name="is_product_selling" @if( !empty( $product->is_product_selling ) && $product->is_product_selling == '1' ) checked @endif data-bootstrap-switch data-on-text="Bật" data-off-text="Tắt" data-off-color="danger" data-on-color="success" data-url="{{ route('product_is_product_selling', $product->id) }}">
                      </td>
                      <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm hide" href="{{ route('product.show',$product->id) }}">
                          <i class="fas fa-folder"></i> Xem
                        </a>
                        <a class="btn btn-info btn-sm" href="{{ route('product.edit',$product->id) }}">
                          <i class="fas fa-pencil-alt"></i> Sửa
                        </a>
                        <button type="button" class="btn btn-danger btn-sm deleteItemModal" data-toggle="modal" data-target="#modal-danger-delete" data-id="{{ $product->id }}" data-url="admin/product/{{ $product->id }}">
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
              {{ $products->appends( request()->query() )->links() }}
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
