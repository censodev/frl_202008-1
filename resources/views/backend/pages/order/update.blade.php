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
        $order              = $data['order'];
        $host_name          = env('APP_URL');
        $list_status        = $data->order_status;
        $products           = unserialize($order->data_cart);
        $date_check_out     = !empty( $order->created_at ) ? date_format( date_create( $order->created_at ),"d/m/Y") : "";
    @endphp

    <!-- Main content -->
    <section class="content">
      <form role="form" action="{{ route('order.update',$order->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        @method('PUT')
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
                  <label for="code_cart">Mã Đơn Hàng</label>
                  <input type="text" id="code_cart" name="code_cart" value="{{ $order->code_cart ?? old('code_cart') }}" class="form-control" @if($order->order_status != 3) disabled @else required @endif>
                </div>
                  <div class="form-group">
                      <label for="customer-info">Thông Tin Giao Hàng</label>
                      <table disabled class="table table-bordered table">
                          <tbody>
                          <tr>
                              <th>Người nhận</th>
                              <th>Số điện thoại</th>
                              <th>Địa chỉ</th>
                              <th>Ngày đặt hàng</th>
                              <th>Ghi chú</th>
                          </tr>
                          <tr style="background: rgb(238, 238, 238);">
                              <td style="background: rgb(238, 238, 238);">{{ $order->name }}</td>
                              <td style="background: rgb(238, 238, 238);">
                                  {{ $order->phone }}
                              </td>
                              <td style="background: rgb(238, 238, 238);">
                                  {{ $order->address }}
                              </td>
                              <td>
                                  {{ $date_check_out ?? '' }}
                              </td>
                              <td>
                                  {!! $order->note !!}
                              </td>
                          </tr>
                          </tbody>
                      </table>
                  </div>
                <div class="form-group">
                  <label for="products">Thông tin bảo hành</label>
                  <table disabled class="table table-bordered table">
                    <tbody>
                      <tr>
                        <th>Tên</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Mã sản phẩm</th>
                        <th>Số seri</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th>Qr code</th>
                        <th>Thành tiền</th>
                      </tr>
                      @foreach($products as $key => $item)
                        <tr style="background: rgb(238, 238, 238);">
                            <td style="background: rgb(238, 238, 238);">{{$item['name']}}</td>
                            <td style="background: rgb(238, 238, 238);">
                              {{ number_format($item['price'], 0, ".", ".") }} đ
                            </td>
                            <td class="text-center" style="background: rgb(238, 238, 238);">
                              {{ $item['quantity'] }}
                            </td>
                            <td>
                                @for($i = 0; $i < (int)$item['quantity']; $i++)
                                    <input name="code_product_{{ $key }}[]" value="{{ !empty($item['code_product'][$i]) ? $item['code_product'][$i] : '' }}" class="form-control" @if($order->order_status != 3) disabled @else required @endif>
                                @endfor
                            </td>
                            <td>
                                @for($i = 0; $i < (int)$item['quantity']; $i++)
                                    <input name="seri_product_{{ $key }}[]" value="{{ !empty($item['seri_product'][$i]) ? $item['seri_product'][$i] : '' }}" class="form-control" @if($order->order_status != 3) disabled @else required @endif>
                                @endfor
                            </td>
                            <td>
                                <input name="begin_guarantee_{{ $key }}" value="{{ !empty($item['begin_guarantee']) ? $item['begin_guarantee'] : '' }}" class="form-control begin_guarantee" @if($order->order_status != 3) disabled @else required @endif>
                            </td>
                            <td>
                                <input name="end_guarantee_{{ $key }}" value="{{ !empty($item['end_guarantee']) ? $item['end_guarantee'] : '' }}" class="form-control end_guarantee" @if($order->order_status != 3) disabled @else required @endif>
                            </td>
                            <td>
                                @if(!empty($item['name_img_qr_code_bao_hanh']))
                                    <img  style="width: 100px;" src="{{  $host_name.'/qr_code_bao_hanh/'.$item['name_img_qr_code_bao_hanh'] }}" title="" alt="">
                                @endif
                            </td>
                            <td style="background: rgb(238, 238, 238); color: red;">
                                {{ number_format($item['total'], 0, ".", ".") }} đ
                            </td>
                        </tr>
                      @endforeach
                      <tr style="background: rgb(238, 238, 238);">
                          <td colspan="8"></td>
                          <td style="background: rgb(238, 238, 238); color: red; font-weight: bold;">
                              Tổng Tiền: {{number_format($order->total_price_cart, 0, ".", ".") }} đ
                          </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>

        <div class="row">
          <div class="col-12">
            <a href="{{ route('order.index') }}" class="btn btn-secondary">Thoát</a>
            @if($order->order_status == 3)
                <input type="submit" value="Lưu" class="btn btn-success float-right">
             @endif
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection
