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
        if( !empty($data['schema_question'])){
            $schema = $data['schema_question'];
            $shows          = unserialize($schema->shows);
            $data_schema    = unserialize($schema->data_schema);
        }
    @endphp

    <!-- Main content -->
    <section class="content">
        <form role="form" action="{{ route('post_schema_question') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                                 <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success add-question">Thêm câu hỏi</button>
                                    </div>
                                    @if(!empty($data_schema['title']))
                                        <div class="list-question">
                                            @foreach($data_schema['title'] as $key => $item)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="type">Câu Hỏi</label>
                                                        <textarea name="title[]" class="form-control" rows="5" required>
                                                            {!! $item ?? old('title') !!}
                                                        </textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="type">Câu trả lời</label>
                                                        <textarea name="reply[]" class="form-control" rows="5" required>
                                                            {!! $data_schema['reply'][$key] ?? old('reply') !!}
                                                        </textarea>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="list-question">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="type">Câu Hỏi</label>
                                                    <textarea name="title[]" class="form-control" rows="5" required>
                                                    </textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="type">Câu trả lời</label>
                                                    <textarea name="reply[]" class="form-control" rows="5" required>
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
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
    @include('backend.includes.clone-item-question')
@endsection
