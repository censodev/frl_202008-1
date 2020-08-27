@extends($data->layout)

@section('title')
    {{ $data->title }}
@endsection
<?php
$carts = session('cart');
$cart_total_price = session('cart_total_price');
?>

@section($data->content)
    <div class="checkout-area pb-45 pt-65">
        <form action="{{ route('order') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            <input type="hidden" name="total_price" value="{{ $cart_total_price }}">
            <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <label>Thông Tin Mua Hàng</label>
                    <div class="billing-info">
                        <input name="name" type="text" class="form-control" placeholder="Họ tên" required>
                    </div>
                    <div class="billing-info">
                        <input name="email" type="text" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="billing-info">
                        <input name="phone" type="text" class="form-control" placeholder="Số điện thoại" required>
                    </div>
                    <div class="billing-info">
                        <textarea name="address" class="form-control" placeholder="Địa chỉ" rows="5" required></textarea>
                    </div>
                    <div class="billing-info">
                        <textarea name="note" class="form-control" placeholder="Lưu ý" rows="5" required></textarea>
                    </div>
                </div>
                <div class="col-lg-3">
                    <label>Phương Thức Thanh Toán</label>
                    <div class="ship-wrapper">
                        <div class="single-ship">
                            <input type="radio" value="COD" name="pay_method" checked>
                            <label>Thanh toán khi giao hàng (COD)</label>
                        </div>
                        <div class="single-ship">
                            <input type="radio" value="VNPAY" name="pay_method">
                            <label>Thanh toán qua VNPAY</label>
                        </div>
                        <div class="single-ship">
                            <input type="radio" value="Ngân Lượng" name="pay_method">
                            <label>Thanh toán qua Ngân Lượng</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="order-review-wrapper">
                        <div class="order-review">
                            <div class="table-responsive">
                                @if(!empty($carts) && count($carts) > 0)
                                    <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="width-1">Tên sản phẩm</th>
                                        <th class="width-2">Giá</th>
                                        <th class="width-3">Số lượng</th>
                                        <th class="width-4">Tổng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($carts as $key => $item)
                                        <tr>
                                            <td>
                                                <div class="o-pro-dec">
                                                    <p>{{ $item['name'] }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="o-pro-price">
                                                    <p>{{ $item['price'] }} đ</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="o-pro-qty">
                                                    <p>{{ $item['quantity'] }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="o-pro-subtotal">
                                                    <p>{{ $item['total'] }} đ</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-left">Tạm Tính </td>
                                        <td colspan="1">{{ $cart_total_price }} đ</td>
                                    </tr>
                                    <tr class="tr-f">
                                        <td colspan="3" class="text-left">Phí Vận Chuyển</td>
                                        <td colspan="1">Cửa hàng sẽ liên hệ lại với khách hàng</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-left">Tổng Tiền</td>
                                        <td colspan="1">{{ $cart_total_price }} đ</td>
                                    </tr>
                                    </tfoot>
                                </table>
                                @endif
                            </div>
                            <div class="billing-back-btn">
                                <div class="billing-btn">
                                    <button type="submit" class="float-right">Đặt Hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
