@php
    use App\Models\frontend\alepay\Alepay;
    use App\Models\frontend\alepay\Utils\AlepayUtils;
@endphp

@extends($data->layout)

@section('title')
    {{ $data->title }}
@endsection

@section($data->content)
    <div class="cart-main-area pt-60 pb-65">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if($data->message)
                        <h5 class="text-order-success">{{ $data->message }}</h5>
                    @else
                        <h5>{{ $data->error }}</h5>
                    @endif
                    <h6 class="info-buy">
                        <a href="<?php echo ('http://' . $_SERVER['SERVER_NAME'] . '/cart') ?>">Nhấn Vào Đây Nếu Bạn Muốn Mua Tiếp</a>
                    </h6>
                </div>
            </div>
        </div>
    </div>

@endsection
