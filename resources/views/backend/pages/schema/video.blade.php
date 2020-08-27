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
        if( !empty($data['schema_video'])){
            $schema = $data['schema_video'];
            $shows          = unserialize($schema->shows);
            $data_schema    = unserialize($schema->data_schema);
        }
    @endphp

    <!-- Main content -->
    <section class="content">
        <form role="form" action="{{ route('post_schema_video') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                                        <label for="name">Tên</label>
                                        <input type="text" name="name" value="{{ $data_schema['name'] ?? old('name') }}" class="form-control" required placeholder="Nhập tên" oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <textarea name="description" class="form-control ckeditor" required placeholder="Nhập mô tả" oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                            {!! $data_schema['description'] ?? old('description') !!}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="uploadDate">Ngày upload</label>
                                        <input type="text" name="uploadDate" value="{{ $data_schema['uploadDate'] ?? old('uploadDate') }}" class="form-control form_datetime" required placeholder="Nhập ngày đăng" oninvalid="this.setCustomValidity('Vui lòng nhập ngày đăng.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="contentUrl">Url Nội Dung</label>
                                        <input type="text" name="contentUrl" value="{{ $data_schema['contentUrl'] ?? old('contentUrl') }}" class="form-control" required placeholder="Nhập url nội dung" oninvalid="this.setCustomValidity('Vui lòng nhập url nội dung.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="embedUrl">Url Nhúng</label>
                                        <input type="text" name="embedUrl" value="{{ $data_schema['embedUrl'] ?? old('embedUrl') }}" class="form-control" required placeholder="Nhập url nhúng" oninvalid="this.setCustomValidity('Vui lòng nhập url nhúng.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="userInteractionCount">Số lượng người tương tác</label>
                                        <input type="text" name="userInteractionCount" value="{{ $data_schema['userInteractionCount'] ?? old('userInteractionCount') }}" class="form-control" required placeholder="Nhập số lượng người tương tác" oninvalid="this.setCustomValidity('Vui lòng nhập số lượng người tương tác.')" oninput="setCustomValidity('')">
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
