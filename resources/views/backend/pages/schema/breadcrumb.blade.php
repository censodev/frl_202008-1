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
        if( !empty($data['schema_breadcrumb'])){
            $schema = $data['schema_breadcrumb'];
            $shows          = unserialize($schema->shows);
            $data_schema    = unserialize($schema->data_schema);
        }
    @endphp

    <!-- Main content -->
    <section class="content">
        <form role="form" action="{{ route('post_schema_breadcrumb') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                                <div class="col-md-12">
{{--                                    <div class="form-group">--}}
{{--                                        <label for="type">Chọn Trang hiển thị</label>--}}
{{--                                        <select class="form-control custom-select" name="shows[]" multiple="multiple" oninvalid="this.setCustomValidity('Vui lòng chọn trang hiển thị.')" oninput="setCustomValidity('')">--}}
{{--                                            <option disabled>--- Lựa Chọn ---</option>--}}
{{--                                            @foreach($data['show_where'] as $key => $show)--}}
{{--                                                <option @if(!empty($shows) && in_array($key,$shows)) selected @endif value="{{ $key }}"> {{ $show }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                    <div class="form-group">
                                        <input type="radio" name="status" value="1" @if(!empty($schema) && ($schema->status == 1)) checked @endif>
                                        <label>Bật</label><br>
                                        <input type="radio" name="status" value="0" @if(!empty($schema) && ($schema->status == 0)) checked @endif>
                                        <label>Tắt</label><br>
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success add-breadcrum">Thêm</button>
                                    </div>
                                    @if(!empty($data_schema['name']))
                                        <div class="list-breadcrum">
                                            @foreach($data_schema['name'] as $key => $item)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="type">Name</label>
                                                        <input type="text" class="form-control" name="name[]" value="{{$item}}" required oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="type">Url</label>
                                                        <input type="text" class="form-control" name="url[]" value="{{$data_schema['url'][$key]}}" required oninvalid="this.setCustomValidity('Vui lòng nhập url.')" oninput="setCustomValidity('')">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="list-breadcrum">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="type">Name</label>
                                                    <input type="text" class="form-control" name="name[]" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="type">Url</label>
                                                    <input type="text" class="form-control" name="url[]" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập url.')" oninput="setCustomValidity('')">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="type">Name</label>
                                            <input type="text" class="form-control" name="name_last" value="{{$data_schema['name_last']}}" required oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
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
    @include('backend.includes.clone-item-breadcrumb')
@endsection
