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

    <!-- Main content -->
    <section class="content">
        <form role="form" action="{{ route('album.store') }}" method="POST" enctype="multipart/form-data"
            accept-charset="utf-8">
            @csrf
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Trường Chính</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body row">
                            <div class="form-group col-md-6">
                                <label>Tiêu đề</label>
                                <input type="text" name="title" placeholder="Nhập tiêu đề"
                                    class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="alt_image">Mô Tả Hình Ảnh</label>
                                <input type="text" id="alt_image" name="alt_image" placeholder="Nhập mô tả hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Tải Ảnh</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                    <a data-input="thumbnail" data-preview="holder" class="lfm-mul btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Chọn Ảnh
                                    </a>
                                    </span>
                                    <input id="thumbnail" class="form-control" type="text" name="image">
                                </div>
                                <div id="holder" class="thumbnail text-center"></div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
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
                    <a href="{{ route('album.index') }}" class="btn btn-secondary">Thoát</a>
                </div>
            </div>
        </form>
        <!-- /.form -->
    </section>
    <!-- /.content -->
@endsection
