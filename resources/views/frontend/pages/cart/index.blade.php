@extends($data->layout)

@section('title')
    {{ $data->title }}
@endsection

@section($data->content)
    <?php
        $carts = session('cart');
        $cart_total_price = session('cart_total_price');
    ?>
    <div class="ereaders-subheader">
        <div class="ereaders-breadcrumb">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li><a href="/" title="trang chủ">Trang chủ</a></li>
                            <li class="active">{{ $data->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ereaders-main-content">
        <div class="ereaders-main-section cart-main-area">
            <div class="container">
                @if(!empty($carts) && count($carts) > 0)
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="cart-shiping-update-wrapper">
                            <div class="cart-shiping-update">
                                <h3>Giỏ hàng của bạn</h3>
                            </div>
                            <a href="{{ $data->url }}" class="continue-buy">Tiếp tục mua hàng <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <form action="{{ route('update-to-cart') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                            @csrf
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Ảnh</th>
                                        <th>Tên Sản Phẩm</th>
                                        <th>Mã Sản Phẩm</th>
                                        <th>Vật Liệu</th>
                                        <th>Giá</th>
                                        <th>Số Lượng</th>
                                        <th>Thành Tiền</th>
                                        <th>Xoá</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $tmp = 0;
                                    @endphp
                                    @foreach($carts as $key => $item)
                                        @php
                                            $tmp++;
                                        @endphp
                                        <tr>
                                            <td>{{ $tmp }}</td>
                                            <td class="product-thumbnail">
                                                <a href="{{ $item['alias'] }}"><img style="width: 100px;" src="{{ $item['image'] }}" alt="{{ $item['alt'] }}" title="{{ $item['title'] }}"></a>
                                            </td>
                                            <td class="product-name"><a href="">{{ $item['name'] }}</a></td>
                                            <td>{{ $item['code'] }}</td>
                                            <td>{{ $item['material'] }}</td>
                                            <td class="product-price-cart"><span class="amount">{{ number_format($item['price'], 0, ".", ".") }} đ</span></td>
                                            <td class="product-quantity">
                                                <div class="pro-dec-cart">
                                                    <input class="cart-plus-minus-box" type="number" value="{{ $item['quantity'] }}" name="quantity[]" min="1" arrt_id="{{ $item['id'] }}">
                                                    <input type="hidden" value="{{ $item['id'] }}" name="id[]">
                                                </div>
                                            </td>
                                            <td class="product-subtotal red-text">{{ number_format($item['total'], 0, ".", ".") }} đ</td>
                                            <td class="product-remove">
                                                <a href="#" data-id="{{ $item['id'] }}"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="cart-shiping-update-wrapper">
                                        <span class="delete-cart"><i class="fa fa-times" aria-hidden="true"></i> Xoá toàn bộ giỏ hàng</span>
                                        <div class="cart-clear">
                                            <div class="grand-totall">
                                                <h4 class="grand-totall-title">TỔNG TIỀN: <span> {{ number_format($cart_total_price, 0, ".", ".") }}đ</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout-area pb-45 pt-65">
                                    <form id="form-infomation" action="{{ route('order') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                                        @csrf
                                        <input type="hidden" name="total_price_form" id="total_price_form" value="{{ $cart_total_price }}">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h4>Thông Tin Mua Hàng</h4>
                                                <div class="billing-info">
                                                    <input name="name" type="text" class="form-control" placeholder="Họ tên (*)" required>
                                                </div>
                                                <div class="billing-info">
                                                    <input name="phone" type="text" class="form-control" placeholder="Số điện thoại (*)" required>
                                                </div>
                                                <div class="billing-info">
                                                    <input name="address" type="text" class="form-control" placeholder="Địa chỉ (*)" required>
                                                </div>
                                                {{-- <div class="billing-info province-country">
                                                    <div class="row">
                                                        <div class="order-province col-md-6 col-sm-6">
                                                            <input name="province" type="text" class="form-control" placeholder="Tỉnh (*)">
                                                        </div>
                                                        <div class="order-country col-md-6 col-sm-6">
                                                            <input name="country" type="text" class="form-control" placeholder="Quốc gia (*)">
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="billing-info order-email">
                                                    <input name="email" type="text" class="form-control" placeholder="Email (*)">
                                                </div>
                                                <div class="billing-info">
                                                    <textarea name="note" class="form-control" placeholder="Thông tin (*)" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6" id="list-pay-method">
                                                <h4>Phương Thức Thanh Toán</h4>
                                                <div class="ship-wrapper">
                                                    <div class="single-ship">
                                                        <input type="radio" value="COD" name="pay_method" checked>
                                                        <label>Thanh toán khi giao hàng (COD)</label>
                                                    </div>
                                                    {{-- <div class="single-ship">
                                                        <input type="radio" value="Visa/Master/JCB" name="pay_method">
                                                        <label>Visa/Master/JCB</label>
                                                    </div>
                                                    <div class="single-ship">
                                                        <input type="radio" value="ATM_ONLINE" name="pay_method">
                                                        <label>Thanh toán bằng thẻ ATM</label>
                                                    </div>
                                                    <div class="single-ship">
                                                        <input type="radio" value="IB_ONLINE" name="pay_method">
                                                        <label>Thanh toán bằng Internet Banking</label>
                                                    </div>
                                                    <div class="single-ship">
                                                        <input type="radio" value="QRCODE" name="pay_method">
                                                        <label>Thanh toán bằng QRCode</label>
                                                    </div>
                                                    <div class="single-ship">
                                                        <input type="radio" value="VAY_MUON" name="pay_method">
                                                        <label>Thanh toán qua Lendmo.vn</label>
                                                    </div>
                                                    <div class="single-ship">
                                                        <input type="radio" value="TRA_GOP" name="pay_method">
                                                        <label>Thanh toán trả góp</label>
                                                    </div> --}}
                                                </div>
                                                <h6 class="red-text">Phí ship: Cửa hàng liên hệ lại với khách hàng</h6>
                                                <div class="billing-back-btn">
                                                    <div class="billing-btn" style="width: 50%">
                                                        <button type="submit" style="width: 100%">Đặt Hàng</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
                @else
                    <h3 class="page-title">Không có sản phẩm nào trong giỏ hàng</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
