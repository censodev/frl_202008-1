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
        if( !empty($data['schema_qa'])){
            $schema = $data['schema_qa'];
            $shows          = unserialize($schema->shows);
            $data_schema    = unserialize($schema->data_schema);
        }
    @endphp

    <!-- Main content -->
    <section class="content">
        <form role="form" action="{{ route('post_schema_qa') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Câu Hỏi</label>
                                        <input type="text" name="name" value="{{ $data_schema['name'] ?? old('name') }}" class="form-control" required placeholder="Nhập tên" oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Mô tả câu hỏi</label>
                                        <textarea name="description" class="form-control" rows="5" required placeholder="Nhập mô tả" oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                            {!! $data_schema['description'] ?? old('description') !!}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="answerCount">Số câu trả lời</label>
                                        <input type="number" name="answerCount" value="{{ $data_schema['answerCount'] ?? old('answerCount') }}" class="form-control" required placeholder="Nhập số lượng câu trả lời" oninvalid="this.setCustomValidity('Vui lòng nhập số lượng câu trả lời.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="upvoteCount">Số phiếu bình chọn</label>
                                        <input type="number" name="upvoteCount" value="{{ $data_schema['upvoteCount'] ?? old('upvoteCount') }}" class="form-control" required placeholder="Nhập số phiếu bình chọn" oninvalid="this.setCustomValidity('Vui lòng nhập số phiếu bình chọn.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="dateCreated">Ngày tạo</label>
                                        <input type="text" name="dateCreated" value="{{ $data_schema['dateCreated'] ?? old('dateCreated') }}" class="form-control form_datetime" required placeholder="Nhập ngày tạo" oninvalid="this.setCustomValidity('Vui lòng nhập ngày tạo.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="author_name">Tác giả</label>
                                        <input type="text" name="author_name" value="{{ $data_schema['author_name'] ?? old('author_name') }}" class="form-control" required placeholder="Nhập tên tác giả" oninvalid="this.setCustomValidity('Vui lòng nhập tên tác giả.')" oninput="setCustomValidity('')">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="descriptionAnswer">Câu trả lời</label>
                                        <textarea name="descriptionAnswer" class="form-control" rows="5" required placeholder="Nhập câu trả lời" oninvalid="this.setCustomValidity('Vui lòng nhập câu trả lời.')" oninput="setCustomValidity('')">
                                            {!! $data_schema['descriptionAnswer'] ?? old('descriptionAnswer') !!}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="dateCreatedAnswer">Ngày tạo</label>
                                        <input type="text" name="dateCreatedAnswer" value="{{ $data_schema['dateCreatedAnswer'] ?? old('dateCreatedAnswer') }}" class="form-control form_datetime" required placeholder="Nhập ngày tạo" oninvalid="this.setCustomValidity('Vui lòng nhập ngày tạo.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="upvoteCountAnswer">Số phiếu bình chọn</label>
                                        <input type="number" name="upvoteCountAnswer" value="{{ $data_schema['upvoteCountAnswer'] ?? old('upvoteCountAnswer') }}" class="form-control" required placeholder="Nhập số phiếu bình chọn" oninvalid="this.setCustomValidity('Vui lòng nhập số phiếu bình chọn.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="urlAnswer">Url câu trả lời</label>
                                        <input type="text" name="urlAnswer" value="{{ $data_schema['urlAnswer'] ?? old('urlAnswer') }}" class="form-control" required placeholder="Nhập url câu trả lời" oninvalid="this.setCustomValidity('Vui lòng nhập url câu trả lời.')" oninput="setCustomValidity('')">
                                    </div>
                                    <div class="form-group">
                                        <label for="author_name_answer">Tác giả</label>
                                        <input type="text" name="author_name_answer" value="{{ $data_schema['author_name_answer'] ?? old('author_name_answer') }}" class="form-control" required placeholder="Nhập tên tác giả" oninvalid="this.setCustomValidity('Vui lòng nhập tên tác giả.')" oninput="setCustomValidity('')">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-success add-qa">Thêm câu trả lời</button>
                                    </div>
                                    @if(!empty($data_schema['descriptionSuggested']))
                                        <div class="list-qa">
                                            @foreach($data_schema['descriptionSuggested'] as $key => $item)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="descriptionSuggested">Câu trả lời</label>
                                                            <textarea name="descriptionSuggested[]" class="form-control" rows="5" required placeholder="Nhập câu trả lời" oninvalid="this.setCustomValidity('Vui lòng nhập câu trả lời.')" oninput="setCustomValidity('')">
                                                                {!! $item ?? old('descriptionSuggested') !!}
                                                            </textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dateCreatedSuggested">Ngày tạo</label>
                                                            <input type="text" name="dateCreatedSuggested[]" value="{{ $data_schema['dateCreatedSuggested'][$key] ?? old('dateCreatedSuggested') }}" class="form-control form_datetime" required placeholder="Nhập ngày tạo" oninvalid="this.setCustomValidity('Vui lòng nhập ngày tạo.')" oninput="setCustomValidity('')">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="upvoteCountSuggested">Số phiếu bình chọn</label>
                                                            <input type="number" name="upvoteCountSuggested[]" value="{{ $data_schema['upvoteCountSuggested'][$key] ?? old('upvoteCountSuggested') }}" class="form-control" required placeholder="Nhập số phiếu bình chọn" oninvalid="this.setCustomValidity('Vui lòng nhập số phiếu bình chọn.')" oninput="setCustomValidity('')">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="urlSuggested">Url câu trả lời</label>
                                                            <input type="text" name="urlSuggested[]" value="{{ $data_schema['urlSuggested'][$key] ?? old('urlSuggested') }}" class="form-control" required placeholder="Nhập url câu trả lời" oninvalid="this.setCustomValidity('Vui lòng nhập url câu trả lời.')" oninput="setCustomValidity('')">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="author_name_suggested">Tác giả</label>
                                                            <input type="text" name="author_name_suggested[]" value="{{ $data_schema['author_name_suggested'][$key] ?? old('author_name_suggested') }}" class="form-control" required placeholder="Nhập tên tác giả" oninvalid="this.setCustomValidity('Vui lòng nhập tên tác giả.')" oninput="setCustomValidity('')">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="list-qa">
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
    @include('backend.includes.clone-item-qa')
@endsection
