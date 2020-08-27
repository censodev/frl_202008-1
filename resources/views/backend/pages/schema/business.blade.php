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
        $week = $data['week'];
        if( !empty($data['schema_business'])){
            $schema         = $data['schema_business'];
            $shows          = unserialize($schema->shows);
            $data_schema    = unserialize($schema->data_schema);
        }
    @endphp

    <!-- Main content -->
    <section class="content">
        <form role="form" action="{{ route('post_schema_business') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Trường Chính</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Chọn Trang hiển thị</label>
                                        <select class="form-control custom-select" name="shows[]" multiple="multiple" oninvalid="this.setCustomValidity('Vui lòng chọn trang hiển thị.')" oninput="setCustomValidity('')">
                                            <option disabled>--- Lựa Chọn ---</option>
                                            @foreach($data['show_where'] as $key => $show)
                                                <option @if(!empty($shows) && in_array($key,$shows)) selected @endif value="{{ $key }}"> {{ $show }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="radio" name="status" value="1" @if(!empty($schema) && ($schema->status == 1)) checked @endif>
                                        <label>Bật</label><br>
                                        <input type="radio" name="status" value="0" @if(!empty($schema) && ($schema->status == 0)) checked @endif>
                                        <label>Tắt</label><br>
                                    </div>
                                    <div class="form-group">
                                        <label for="url">Url</label>
                                        <input type="text" name="url" value="{{ $data_schema['url'] ?? old('url') }}" class="form-control" required placeholder="Nhập url" oninvalid="this.setCustomValidity('Vui lòng nhập url.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Tên Doanh Nghiệp</label>
                                        <input type="text" name="name" value="{{ $data_schema['name'] ?? old('name') }}" class="form-control" required placeholder="Nhập tên doanh nghiệp" oninvalid="this.setCustomValidity('Vui lòng nhập tên doanh nghiệp.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="author">Chủ sở hữu</label>
                                        <input type="text" name="author" value="{{ $data_schema['author'] ?? old('author') }}" class="form-control" required placeholder="Nhập chủ sở hữu" oninvalid="this.setCustomValidity('Vui lòng nhập chủ sở hữu.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="streetAddress">Địa Chỉ Đường</label>
                                        <input type="text" name="streetAddress" value="{{ $data_schema['streetAddress'] ?? old('streetAddress') }}" class="form-control" required placeholder="Nhập địa chỉ đường" oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ đường.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="addressLocality">Địa Chỉ Phường, Quận</label>
                                        <input type="text" name="addressLocality" value="{{ $data_schema['addressLocality'] ?? old('addressLocality') }}" class="form-control" required placeholder="Nhập địa chỉ phường, quận" oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ phường, quận.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="addressRegion">Địa Chỉ Thành Phố</label>
                                        <input type="text" name="addressRegion" value="{{ $data_schema['addressRegion'] ?? old('addressRegion') }}" class="form-control" required placeholder="Nhập địa chỉ thành phố" oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ thành phố.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="postalCode">Mã Bưu Điện</label>
                                        <input type="text" name="postalCode" value="{{ $data_schema['postalCode'] ?? old('postalCode') }}" class="form-control" required placeholder="Nhập mã bưu điện" oninvalid="this.setCustomValidity('Vui lòng nhập mã bưu điện.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="addressCountry">Địa Chỉ Quốc Gia</label>
                                        <input type="text" name="addressCountry" value="{{ $data_schema['addressCountry'] ?? old('addressCountry') }}" class="form-control" required placeholder="Nhập địa chỉ quốc gia" oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ quốc gia.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="latitude">Vĩ độ</label>
                                        <input type="text" name="latitude" value="{{ $data_schema['latitude'] ?? old('latitude') }}" class="form-control" required placeholder="Nhập vĩ độ" oninvalid="this.setCustomValidity('Vui lòng nhập vĩ độ.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="longitude">Kinh độ</label>
                                        <input type="text" name="longitude" value="{{ $data_schema['longitude'] ?? old('longitude') }}" class="form-control" required placeholder="Nhập kinh độ" oninvalid="this.setCustomValidity('Vui lòng nhập kinh độ.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="url">Url Địa Chỉ</label>
                                        <input type="text" name="url_address" value="{{ $data_schema['url_address'] ?? old('url_address') }}" class="form-control" required placeholder="Nhập url địa chỉ" oninvalid="this.setCustomValidity('Vui lòng nhập url địc chỉ.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="priceRange">Phạm Vi Giá</label>
                                        <input type="text" name="priceRange" value="{{ $data_schema['priceRange'] ?? old('priceRange') }}" class="form-control" required placeholder="Nhập phạm vi giá" oninvalid="this.setCustomValidity('Vui lòng nhập phạm vi giá.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="telephone">Số điện thoại</label>
                                        <input type="text" name="telephone" value="{{ $data_schema['telephone'] ?? old('telephone') }}" class="form-control" required placeholder="Nhập số điện thoại" oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label class="add-date-time">Thời Gian</label>
                                        <div class="list-date-time">
                                            <label>Ngày, giờ</label>
                                            <select class="form-control custom-select select-day-schema" name="day[]" multiple="multiple" oninvalid="this.setCustomValidity('Vui lòng chọn ngày trong tuần.')" oninput="setCustomValidity('')">
                                                @foreach($week as $key => $day)
                                                    <option value="{{ $key }}" @if(!empty($data_schema['day']) && (in_array($key, $data_schema['day']))) selected @endif> {{ $day }}</option>
                                                @endforeach
                                            </select>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="time_open">Giờ mở cửa</label>
                                                    <input type="text" name="time_open" value="{{ $data_schema['time_open'] ?? old('time_open') }}" class="form-control time_open" required placeholder="Nhập giờ mở cửa" oninvalid="this.setCustomValidity('Vui lòng nhập giờ mở cửa.')" oninput="setCustomValidity('')">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="time_close">Giờ đóng cửa</label>
                                                    <input type="text" name="time_close" value="{{ $data_schema['time_open'] ?? old('time_open') }}" class="form-control time_close" required placeholder="Nhập giờ đóng cửa" oninvalid="this.setCustomValidity('Vui lòng nhập giờ đóng cửa.')" oninput="setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Giá trị review</label>
                                        <input type="number" name="ratingValue" value="{{ $data_schema['ratingValue'] ?? old('ratingValue') }}" class="form-control" required placeholder="Nhập giá trị review" oninvalid="this.setCustomValidity('Vui lòng nhập giá trị review.')" oninput="setCustomValidity('')">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="card-body pb-0">
                                            <div class="row d-flex align-items-stretch increment-thumbnail">
                                                @if( !empty( $data_schema['images'] ) && count( $data_schema['images'] ) > 0 )
                                                    @foreach( $data_schema['images'] as $key => $image )
                                                        <div class="col-md-12 d-flex align-items-stretch">
                                                            <div class="card bg-light box-image-chema">
                                                                <div class="card-header text-muted border-bottom-0">
                                                                    Hình Ảnh
                                                                </div>
                                                                <div class="card-body pt-0">
                                                                    <div class="form-group">
                                                                        <div id="holder" class="thumbnail text-center">
                                                                            <img src="{{ $image }}" style="height: 5rem;">
                                                                        </div>
                                                                        <div class="input-group">
                                                                            <span class="input-group-btn">
                                                                              <a data-input="thumbnail" data-preview="holder" class="lfm-mul btn btn-primary">
                                                                                <i class="fa fa-picture-o"></i> Chọn Ảnh
                                                                              </a>
                                                                            </span>
                                                                            <input id="thumbnail" value="{{ $image }}" class="form-control" type="text" name="images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="form-group text-right">
                                                <button class="btn-clone-thumbnail btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Hình Ảnh</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card-body text-center">
                    <button type="submit" name="save_and_exits" value="1" class="btn btn-success" role="button">
                        Lưu Và Thoát
                    </button>
                    <button type="submit" name="save_and_exits" value="2" class="btn btn-success" role="button">
                        Lưu
                    </button>
                    <a href="{{ route('schema.index') }}" class="btn btn-secondary">Thoát</a>
                </div>
            </div>
        </form>
        <!-- /.form -->
    </section>
    <!-- /.content -->
    @include('backend.includes.clone-image-schema')
    @include('backend.includes.clone-day-time')
@endsection
