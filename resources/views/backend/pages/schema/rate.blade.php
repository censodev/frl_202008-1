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
        $type = $data['type'];
        if( !empty($data['schema_rate'])){
            $schema = $data['schema_rate'];
            $shows          = unserialize($schema->shows);
            $data_schema    = unserialize($schema->data_schema);
        }
    @endphp

    <!-- Main content -->
    <section class="content">
        <form role="form" action="{{ route('post_schema_rate') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                                        <label for="type">Chọn loại</label>
                                        <select class="form-control custom-select" name="type" required oninvalid="this.setCustomValidity('Vui lòng chọn loại.')" oninput="setCustomValidity('')">
                                            <option selected disabled>--- Lựa Chọn ---</option>
                                            @foreach($data['type'] as $key => $type)
                                                <option value="{{ $key }}" @if(!empty($data_schema['type']) && ($data_schema['type'] == $key)) selected @endif> {{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Tên</label>
                                        <input type="text" name="name" value="{{ $data_schema['name'] ?? old('name') }}" class="form-control" required placeholder="Nhập tên" oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Dịch Vụ</label>
                                        <input type="text" name="servesCuisine" value="{{ $data_schema['servesCuisine'] ?? old('servesCuisine') }}" class="form-control" required placeholder="Nhập dịch vụ" oninvalid="this.setCustomValidity('Vui lòng nhập dịch vụ.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Đơn Vị Tiền Tệ</label>
                                        <input type="text" name="priceRange" value="{{ $data_schema['priceRange'] ?? old('priceRange') }}" class="form-control" required placeholder="Nhập đơn vị tiền tệ" oninvalid="this.setCustomValidity('Vui lòng nhập đơn vị tiền tệ.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Số điện thoại</label>
                                        <input type="text" name="telephone" value="{{ $data_schema['telephone'] ?? old('telephone') }}" class="form-control" required placeholder="Nhập số điện thoại" oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại.')" oninput="setCustomValidity('')">
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
                                        <label>Giá trị review</label>
                                        <input type="number" name="ratingValue" value="{{ $data_schema['ratingValue'] ?? old('ratingValue') }}" class="form-control" required placeholder="Nhập giá trị review" oninvalid="this.setCustomValidity('Vui lòng nhập giá trị review.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="author_name">Tác giả</label>
                                        <input type="text" name="author_name" value="{{ $data_schema['author_name'] ?? old('author_name') }}" class="form-control" required placeholder="Nhập tác giả" oninvalid="this.setCustomValidity('Vui lòng nhập tác giả.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="organization_name">Tổ Chức</label>
                                        <input type="text" name="organization_name" value="{{ $data_schema['organization_name'] ?? old('organization_name') }}" class="form-control" required placeholder="Nhập tổ chức" oninvalid="this.setCustomValidity('Vui lòng nhập tổ chức.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="reviewBody">Nội dung đánh giá</label>
                                        <textarea name="reviewBody" class="form-control ckeditor" required placeholder="Nhập nội dung đánh giá" oninvalid="this.setCustomValidity('Vui lòng nhập nội dung đánh giá.')" oninput="setCustomValidity('')">
                                            {!! $data_schema['reviewBody'] ?? old('reviewBody') !!}
                                        </textarea>
                                    </div>
                                    <div id="holder" class="thumbnail text-center">
                                        @if( !empty( $data_schema['image'] ) )
                                            <img src="{{ $data_schema['image'] }}" style="height: 5rem;">
                                        @endif
                                    </div>
                                    <div class="input-group">
                                          <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                              <i class="fa fa-picture-o"></i> Ảnh
                                            </a>
                                          </span>
                                        <input id="thumbnail" class="form-control" type="text" required name="image" value="{{ $data_schema['image'] ?? '' }}">
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
@endsection
