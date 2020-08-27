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
        $colors = $data['colors'];
        $materials = $data['materials'];
    @endphp

    <section class="content">
        <form role="form" action="{{ route('productConfig.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
            {{ csrf_field() }}
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
                            <div class="row d-flex align-items-stretch increment-material">
                                @if(!empty($materials) && count($materials) > 0)
                                    @foreach($materials as $key => $item)
                                        <div class="col-md-4 align-items-stretch clone-material-cli">
                                            <div class="card bg-light">
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Vật Liệu</label>
                                                                <input type="hidden" name="material_id[]" value="{{ $item->id }}">
                                                                <input type="text" name="material_name[]" placeholder="Nhập vật liệu" class="form-control" value="{{ $item->name }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="text-right">
                                                        <button class="btn btn-sm btn-danger btn-remove-material" type="button">
                                                            <i class="fas fa-trash"></i> Xóa
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group text-right">
                                <button class="btn-clone-material btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm vật liệu</button>
                            </div>


                            <div class="row d-flex align-items-stretch increment-color">
                                @if(!empty($colors) && count($colors) > 0)
                                    @foreach($colors as $key => $item)
                                        <div class="col-md-4 align-items-stretch clone-color-cli">
                                            <div class="card bg-light">
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label>Tên màu</label>
                                                                <input type="hidden" name="color_id[]" value="{{ $item->id }}">
                                                                <input type="text" name="color_name[]" value="{{ $item->name }}" placeholder="Nhập tên màu" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Mã màu</label>
                                                                <input type="color" name="color_value[]" value="{{ $item->value }}" class="form-control" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="text-right">
                                                        <button class="btn btn-sm btn-danger btn-remove-color" type="button">
                                                            <i class="fas fa-trash"></i> Xóa
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group text-right">
                                <button class="btn-clone-color btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm màu</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            </div>

            <div class="row">
                <div class="card-body text-center">
                    <button type="submit" name="save_and_exits" value="2" class="btn btn-success" role="button">
                        Lưu
                    </button>
                </div>
            </div>
        </form>
    </section>

    @include('backend.includes.clone-product-color')
    @include('backend.includes.clone-product-material')

@endsection
