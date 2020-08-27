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
        if( !empty($data['schema_event'])){
            $schema = $data['schema_event'];
            $shows          = unserialize($schema->shows);
            $data_schema    = unserialize($schema->data_schema);
        }
    @endphp

    <!-- Main content -->
    <section class="content">
        <form role="form" action="{{ route('post_schema_event') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
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
                                        <label for="headline">Tên</label>
                                        <input type="text" name="name" value="{{ $data_schema['name'] ?? old('name') }}" class="form-control" required placeholder="Nhập tên sự kiện" oninvalid="this.setCustomValidity('Vui lòng nhập tên sự kiện.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <textarea name="description" class="form-control ckeditor" required placeholder="Nhập mô tả sản phẩm" oninvalid="this.setCustomValidity('Vui lòng nhập mô tả sản phẩm.')" oninput="setCustomValidity('')">
                                            {{ $data_schema['description'] ?? old('description') }}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Thời gian bắt đầu</label>
                                        <input type="text" name="startDate" value="{{ $data_schema['startDate'] ?? old('startDate') }}" class="form-control form_datetime" required placeholder="Nhập thời gian bắt đầu" oninvalid="this.setCustomValidity('Vui lòng nhập thời gian bắt đầu.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Thời gian kết thúc</label>
                                        <input type="text" name="endDate" value="{{ $data_schema['endDate'] ?? old('endDate') }}" class="form-control form_datetime" required placeholder="Nhập thời gian kết thúc" oninvalid="this.setCustomValidity('Vui lòng nhập thời gian kết thúc.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Nơi diễn ra</label>
                                        <input type="text" name="nameAddress" value="{{ $data_schema['name'] ?? old('name') }}" class="form-control" required placeholder="Nhập nơi diễn ra" oninvalid="this.setCustomValidity('Vui lòng nhập nơi diễn ra.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Tên đường</label>
                                        <input type="text" name="streetAddress" value="{{ $data_schema['streetAddress'] ?? old('streetAddress') }}" class="form-control" required placeholder="Nhập tên đường" oninvalid="this.setCustomValidity('Vui lòng nhập tên đường.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Phường, Quận</label>
                                        <input type="text" name="addressRegion" value="{{ $data_schema['addressRegion'] ?? old('addressRegion') }}" class="form-control" required placeholder="Nhập phường, quận" oninvalid="this.setCustomValidity('Vui lòng nhập phường, quận.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Thành Phố</label>
                                        <input type="text" name="addressLocality" value="{{ $data_schema['addressLocality'] ?? old('addressLocality') }}" class="form-control" required placeholder="Nhập thành phố" oninvalid="this.setCustomValidity('Vui lòng nhập thành phố.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Quốc Gia</label>
                                        <input type="text" name="addressCountry" value="{{ $data_schema['addressCountry'] ?? old('addressCountry') }}" class="form-control" required placeholder="Nhập quốc gia" oninvalid="this.setCustomValidity('Vui lòng nhập quốc gia.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Mã Bưu Điện</label>
                                        <input type="text" name="postalCode" value="{{ $data_schema['postalCode'] ?? old('postalCode') }}" class="form-control" required placeholder="Nhập mã bưu điện" oninvalid="this.setCustomValidity('Vui lòng nhập mã bưu điện')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Giá</label>
                                        <input type="text" name="price" value="{{ $data_schema['price'] ?? old('price') }}" class="form-control" required placeholder="Nhập giá" oninvalid="this.setCustomValidity('Vui lòng nhập giá')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Url Offer</label>
                                        <input type="text" name="offer_url" value="{{ $data_schema['offer_url'] ?? old('offer_url') }}" class="form-control" required placeholder="Nhập url offer" oninvalid="this.setCustomValidity('Vui lòng nhập url offer')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Đơn vị tiền tệ</label>
                                        <input type="text" name="priceCurrency" value="{{ $data_schema['priceCurrency'] ?? old('priceCurrency') }}" class="form-control" required placeholder="Nhập đơn vị tiền tệ" oninvalid="this.setCustomValidity('Vui lòng nhập đơn vị tiền tệ')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Giờ bán vé</label>
                                        <input type="text" name="validFrom" value="{{ $data_schema['validFrom'] ?? old('validFrom') }}" class="form-control form_datetime" required placeholder="Nhập thời gian bán vé" oninvalid="this.setCustomValidity('Vui lòng nhập thời gian bán vé.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Người biểu diễn</label>
                                        <input type="text" name="performer_name" value="{{ $data_schema['performer_name'] ?? old('performer_name') }}" class="form-control" required placeholder="Nhập người biểu diễn" oninvalid="this.setCustomValidity('Vui lòng nhập người biểu diễn.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Tổ Chức</label>
                                        <input type="text" name="organization_name" value="{{ $data_schema['organization_name'] ?? old('organization_name') }}" class="form-control" required placeholder="Nhập tổ chức" oninvalid="this.setCustomValidity('Vui lòng nhập tổ chức.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Url Tổ Chức</label>
                                        <input type="text" name="organization_url" value="{{ $data_schema['organization_url'] ?? old('organization_url') }}" class="form-control" required placeholder="Nhập url tổ chức" oninvalid="this.setCustomValidity('Vui lòng nhập url tổ chức.')" oninput="setCustomValidity('')">
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
@endsection
