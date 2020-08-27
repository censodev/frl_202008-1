@extends($data->layout, [
    'title'             => 'Chi tiết Order',
    "seo_title"         => 'Chi tiết Order',
    'og_image'          => 'Chi tiết Order',
    'og_url'            => 'Chi tiết Order',
    'seo_description'   => 'Chi tiết Order',
    'seo_keywords'      => 'Chi tiết Order',
    'category'          => 'Chi tiết Order',
])

@section('title')
    {{ $data->title }}
@endsection

<?php
    $order = $data['detailOrder'];
    $products = unserialize($order->data_cart);
    $date_check_out = !empty( $order->created_at ) ? date_format( date_create( $order->created_at ),"d/m/Y") : "";
?>

@section($data->content)
    <div class="breadcrumb-area gray-bg-7">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ Request::root() }}">Trang chủ</a></li>
                    <li class="active">{{ $data->title }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="shop-page-area pt-30 pb-65">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-12">
                    <div class="tab-content jump">
                        <div class="tab-pane active pb-20" id="product-grid">
                            <div class="row">

                                <div class="col-md-12">
                                    <label for="customer-info">Thông Tin Giao Hàng</label>
                                    <table class="table table-bordered table">
                                        <tbody>
                                        <tr>
                                            <th>Người nhận</th>
                                            <th>Số điện thoại</th>
                                            <th>Địa chỉ</th>
                                        </tr>
                                        <tr style="background: rgb(238, 238, 238);">
                                            <td style="background: rgb(238, 238, 238);">{{ $order->name }}</td>
                                            <td style="background: rgb(238, 238, 238);">
                                                {{ $order->phone }}
                                            </td>
                                            <td style="background: rgb(238, 238, 238);">
                                                {{ $order->address }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <label for="products">Sản Phẩm</label>
                                    <table class="table table-bordered table">
                                        <tbody>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Đơn giá ( VNĐ )</th>
                                            <th class="text-center">Số lượng</th>
                                            <th>Thành tiền ( VNĐ )</th>
                                        </tr>
                                        @foreach($products as $item)
                                            <tr style="background: rgb(238, 238, 238);">
                                                <td style="background: rgb(238, 238, 238);">
                                                    {{$item['name']}}
                                                </td>
                                                <td style="background: rgb(238, 238, 238);">
                                                    {{ number_format($item['price'], 0, ".", ".") }} đ
                                                </td>
                                                <td class="text-center" style="background: rgb(238, 238, 238);">
                                                    {{$item['quantity']}}
                                                </td>
                                                <td style="background: rgb(238, 238, 238);">
                                                    {{ number_format($item['total'], 0, ".", ".") }} đ
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <label for="order_code">Mã Đơn Hàng: </label> <b style="color:red;">{{ $order->code_cart }}</b>
                                </div>
                                <div class="col-md-6">
                                    <label for="total_price">Tổng Tiền: </label> <b style="color: red;">{{number_format($order->total_price_cart, 0, ".", ".") }} đ</b>
                                </div>
                                <div class="col-md-6">
                                    <label for="date_checkout">Ngày Đặt Hàng: </label> <b style="color: red;">{{ $date_check_out ?? '' }}</b>
                                </div>
                                @php
                                    $list = array("Đang đặt", "Đang xử lí", "Đang Vận Chuyển","Hoàn Tất" , "Đã Hủy" );
                                @endphp
                                <div class="col-md-6">
                                    <label for="show_menu_alias">Trạng thái đơn hàng: </label> <b style="color: red;">{{ $list[$order->order_status] }}</b>
                                </div>
                                <div class="col-md-12">
                                    <label for="note">Ghi Chú Khách Hàng</label>
                                    <div>{!! $order->note !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
