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
        if( !empty($data['schema_tutorial'])){
            $schema = $data['schema_tutorial'];
            $shows          = unserialize($schema->shows);
            $data_schema    = unserialize($schema->data_schema);

            $name_step          = $data_schema['name_step'];
            $url_step           = $data_schema['url_step'];
            $step_one           = $data_schema['step_one'];
            $step_two           = $data_schema['step_two'];
            $image_step         = $data_schema['image_step'];
            $width_image_step   = $data_schema['width_image_step'];
            $height_image_step  = $data_schema['height_image_step'];
        }

    @endphp

    <!-- Main content -->
    <section class="content">
        <form role="form" action="{{ route('post_schema_tutorial') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                                <div class="col-md-12">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tên</label>
                                        <input type="text" name="name" value="{{ $data_schema['name'] ?? old('name') }}" class="form-control" required placeholder="Nhập tên" oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <textarea name="description" class="form-control" rows="5" required placeholder="Nhập mô tả" oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                            {!! $data_schema['description'] ?? old('description') !!}
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
                                              <i class="fa fa-picture-o"></i> Hình ảnh
                                            </a>
                                          </span>
                                        <input id="thumbnail" class="form-control" type="text" required name="image" value="{!! $data_schema['image'] ?? old('image') !!}" required oninvalid="this.setCustomValidity('Vui lòng chọn ảnh.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Chiều rộng ảnh</label>
                                        <input type="text" name="width_image" value="{!! $data_schema['width_image'] ?? old('width_image') !!}" class="form-control" required placeholder="Nhập chiều rộng ảnh" oninvalid="this.setCustomValidity('Vui lòng nhập chiều rộng ảnh.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label>Chiều cao ảnh</label>
                                        <input type="text" name="height_image" value="{!! $data_schema['height_image'] ?? old('height_image') !!}" class="form-control" required placeholder="Nhập chiều cao ảnh" oninvalid="this.setCustomValidity('Vui lòng nhập chiều cao ảnh.')" oninput="setCustomValidity('')">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success add-tutorial">Thêm bước</button>
                                    </div>
                                    <div class="list-tutorial">
                                        <div class="row">
                                            @foreach($name_step as $key => $item)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tên</label>
                                                        <input type="text" name="name_step[]" value="{{ $item ?? old('name_step') }}" class="form-control" required placeholder="Nhập tên" oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Url</label>
                                                        <input type="text" name="url_step[]" value="{{ $url_step[$key] ?? old('url_step') }}" class="form-control" required placeholder="Nhập url" oninvalid="this.setCustomValidity('Vui lòng nhập url.')" oninput="setCustomValidity('')">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bước 1</label>
                                                        <input type="text" name="step_one[]" value="{{ $step_one[$key] ?? old('step_one') }}" class="form-control" required placeholder="Nhập bước 1" oninvalid="this.setCustomValidity('Vui lòng nhập bước 1.')" oninput="setCustomValidity('')">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Bước 2</label>
                                                        <input type="text" name="step_two[]" value="{{ $step_two[$key] ?? old('step_two') }}" class="form-control" required placeholder="Nhập bước 2" oninvalid="this.setCustomValidity('Vui lòng nhập bước 2.')" oninput="setCustomValidity('')">
                                                    </div>
                                                    <div id="holder" class="thumbnail text-center">
                                                        @if( !empty( $image_step[$key] ) )
                                                            <img src="{{ $image_step[$key] }}" style="height: 5rem;">
                                                        @endif
                                                    </div>
                                                    <div class="input-group">
                                                          <span class="input-group-btn">
                                                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                                              <i class="fa fa-picture-o"></i>Hình ảnh
                                                            </a>
                                                          </span>
                                                        <input id="thumbnail" class="form-control" type="text" required name="image_step[]" value="{{ $image_step[$key] ?? old('image_step') }}" required oninvalid="this.setCustomValidity('Vui lòng chọn ảnh.')" oninput="setCustomValidity('')">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Chiều rộng ảnh</label>
                                                        <input type="text" name="width_image_step[]" value="{{ $width_image_step[$key] ?? old('width_image_step') }}" class="form-control" required placeholder="Nhập chiều rộng ảnh" oninvalid="this.setCustomValidity('Vui lòng nhập chiều rộng ảnh.')" oninput="setCustomValidity('')">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Chiều cao ảnh</label>
                                                        <input type="text" name="height_image_step[]" value="{{ $height_image_step[$key] ?? old('height_image_step') }}" class="form-control" required placeholder="Nhập chiều cao ảnh" oninvalid="this.setCustomValidity('Vui lòng nhập chiều cao ảnh.')" oninput="setCustomValidity('')">
                                                    </div>
                                                </div>
                                            @endforeach
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
    @include('backend.includes.clone-item-tutorial')
@endsection
