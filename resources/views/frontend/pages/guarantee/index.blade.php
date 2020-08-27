@extends($data->layout)

@section('title')
    {{ $data->title }}
@endsection
@php
    $image_qr_baohanh           = $data['image_qr_baohanh'];
    $host_name                  = env('APP_URL');
@endphp
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
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-12">
                <div class="tab-content jump">
                    <div class="tab-pane active pb-20" style="text-align: center;">
                        <img  style="width: 300px;" src="{{  $host_name.'/qr_code_bao_hanh/'.$image_qr_baohanh }}" title="{{ $image_qr_baohanh }}" alt="{{ $image_qr_baohanh }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
