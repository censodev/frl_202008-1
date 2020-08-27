@extends($data->layout, [
    'title'             => 'Danh sách Order của đại lý',
    "seo_title"         => 'Danh sách Order của đại lý',
    'og_image'          => 'Danh sách Order của đại lý',
    'og_url'            => 'Danh sách Order của đại lý',
    'seo_description'   => 'Danh sách Order của đại lý',
    'seo_keywords'      => 'Danh sách Order của đại lý',
    'category'          => 'Danh sách Order của đại lý'
])

@section('title')
    {{ $data->title }}
@endsection

<?php
    $listOrder =  !empty($data['listOrder']) ? $data['listOrder'] : [];
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
                            <div class="row table-responsive">

                                @if(!empty($listOrder) && count($listOrder) > 0)
                                    <table class="table table-striped" id="listOrder">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Mã</th>
                                            <th scope="col">Ngày đặt</th>
                                            <th scope="col">Khách hàng</th>
                                            <th scope="col">Tình trạng</th>
                                            <th scope="col">Thành tiền</th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                    <tbody>
                                    @foreach($listOrder as $key => $item)
                                        <tr>
                                            <th scope="row">{{ $key++ }}</th>
                                            <td><a href="">{{ $item->code_cart }}</a></td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>
                                                @php
                                                    switch ($item->order_status) {
                                                      case 0:
                                                        echo '<span class="badge badge-secondary">Đang Đặt</span>';
                                                        break;
                                                      case 1:
                                                        echo '<span class="badge bg-warning">Đang Xử Lí</span>';
                                                        break;
                                                      case 2:
                                                        echo '<span class="badge bg-primary">Đang vận chuyển</span>';
                                                        break;
                                                      case 3:
                                                      echo '<span class="badge bg-success">Hoàn tất</span>';
                                                        break;
                                                      case 4:
                                                      echo '<span class="badge bg-danger">Đã hủy</span>';
                                                        break;
                                                      default:
                                                        echo '';
                                                        break;
                                                    }
                                                @endphp
                                            </td>
                                            <td>{{ number_format($item->total_price_cart, 0, ".", ".") }} đ</td>
                                            <td><b><a href="{{ route('detail-order-agency', $item->id) }}">Xem</a></b></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                    <h4>Chưa có order</h4>
                                @endif
                            </div>
                        </div>

                        @if(!empty($listOrder) && count($listOrder) > 0)
                            {{ $listOrder->links('frontend.includes.pagination') }}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
