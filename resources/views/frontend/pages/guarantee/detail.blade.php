@extends($data->layout)

@section('title')
    {{ $data->title }}
@endsection
@php
    $product = !empty($data['product']) ? $data['product'] : [];
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
    <div class="shop-page-area pt-30 pb-65">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-lg-12">
                    <div class="tab-content jump">
                        <div class="tab-pane active pb-20">
                            <div class="row table-responsive">
                                @if(!empty($product) && count($product) > 0)
                                    <table disabled class="table table-bordered table">
                                        <tbody>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Mã sản phẩm</th>
                                                <th>Bắt đầu bảo hành</th>
                                                <th>Kết thúc bảo hành</th>
                                            </tr>
                                            <tr style="background: rgb(238, 238, 238);">
                                                    <td style="background: rgb(238, 238, 238);">{{$product['name']}}</td>
                                                    <th>
                                                        @for($i = 0; $i < count($product['code_product']); $i++)
                                                            <p>{{ !empty($product['code_product'][$i]) ? $product['code_product'][$i] : '' }}</p>
                                                        @endfor
                                                    </th>
                                                    <th>
                                                        {{ !empty($product['begin_guarantee']) ? $product['begin_guarantee'] : '' }}
                                                    </th>
                                                    <th>
                                                        {{ !empty($product['end_guarantee']) ? $product['end_guarantee'] : '' }}
                                                    </th>
                                                </tr>
                                        </tbody>
                                    </table>
                                @else
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
