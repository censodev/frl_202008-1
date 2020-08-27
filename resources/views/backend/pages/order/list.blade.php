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
        $orders             = $data['orders'];
        $list_agency        = $data->agency;
        $list_status        = $data->order_status;
        $host_name = env('APP_URL');
    @endphp

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
                            Qr Code
                        </th>
                        <th>
                            Ngày đặt
                        </th>
                        <th>
                            Khách hàng
                        </th>
                        <th>
                            Tình trạng
                        </th>
                        <th>
                            Đại Lý
                        </th>
                        <th>
                            Thành Tiền
                        </th>
                        <th style="width: 20%">
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($orders as $key => $order)
                        @php
                            $date_check_out = !empty( $order->created_at ) ? date_format( date_create( $order->created_at ),"d/m/Y") : "";
                        @endphp
                        <tr>
                            <td> {{ ($key + 1) }} </td>
                            <td>
                                <img  style="width: 100px;" src="{{  $host_name.'/qr_code/'.$order->image_qr_code }}" title="" alt="">
                            </td>
                            <td>
                                {{ $date_check_out }}
                            </td>
                            <td>
                                {{$order->name}}
                            </td>
                            <td>
                                <select class="form-control change-status-order" name="order_status" data-id-order="{{ $order->id }}">
                                    <option value="" selected disabled>Chọn trạng thái</option>
                                    @foreach($list_status as $key =>  $value)
                                        <option value="{{$key}}" <?php if($key == $order->order_status) { echo "selected"; }  ?> >
                                            {{$value}}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control select-change-agency" name="agency" data-id-order="{{ $order->id }}">
                                    <option value="" selected disabled>Chọn đại lý</option>
                                    @if(!empty($list_agency) && count($list_agency))
                                        @foreach($list_agency as $key => $agency)
                                            <option value="{{ $agency->id }}" @if($order->agency_id == $agency->id) selected @endif>{{ $agency->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                {{ number_format($order->total_price_cart) }} đ
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('order.edit',$order->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Sửa
                                </a>
                                <button type="button" class="btn btn-danger btn-sm deleteItemModal" data-toggle="modal" data-target="#modal-danger-delete" data-id="{{ $order->id }}" data-url="admin/order/{{ $order->id }}">
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
                        {{ $orders->links() }}
                    </ul>
                </nav>
            </div>
            <!-- /.card-footer -->

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
