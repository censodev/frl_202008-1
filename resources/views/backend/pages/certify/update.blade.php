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
        $certify  = $data['certify'];

        $certify_images       = json_decode( $certify->images );
        $certify_title_image  = json_decode( $certify->title_image );
        $certify_alt_image    = json_decode( $certify->alt_image );
        $certify_button_title = json_decode( $certify->button_title );
        $certify_button_link  = json_decode( $certify->button_link );
    @endphp

    <!-- Main content -->
    <section class="content">
        <form role="form" action="{{ route('certify.update',$certify->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $certify->id }}">
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
                            <div class="form-group">
                                <label for="title">Tiêu đề</label>
                                <input type="text" id="title" name="title" value="{{ $certify->title ?? old('title') }}" class="form-control" required placeholder="Nhập tiêu đề" oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                @if( $errors->has('title') )
                                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                                @endif
                            </div>

                            <!-- Default box -->
                            <div class="card card-solid">
                                <div class="card-header">
                                    <h3 class="card-title">Hình Ảnh</h3>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="row d-flex align-items-stretch increment-thumbnail">

                                        @if( !empty( $certify_images ) && count( $certify_images ) > 0 )
                                            @foreach( $certify_images as $key => $images )
                                                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch @if( $key > 0 ) clone-thumbnail-cli @endif ">
                                                    <div class="card bg-light">
                                                        <div class="card-header text-muted border-bottom-0">
                                                            Hình Ảnh
                                                        </div>
                                                        <div class="card-body pt-0">
                                                            <div class="form-group">
                                                                <div id="holder-{{ $key }}" class="thumbnail holder-thumbnail text-center">
                                                                    <img src="{{ $images }}" style="height: 5rem;">
                                                                </div>
                                                                <div class="input-group">
                                    <span class="input-group-btn">
                                      <a data-input="thumbnail-{{ $key }}" data-preview="holder-{{ $key }}" class="lfm-mul btn btn-primary">
                                        <i class="fa fa-picture-o"></i> Chọn Ảnh
                                      </a>
                                    </span>
                                                                    <input id="thumbnail-{{ $key }}" class="form-control" type="text" name="images[]" value="{{ $images }}" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="title_image">Tiêu Đề Hình Ảnh</label>
                                                                <input type="text" id="title_image" name="title_image[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ $certify_title_image[$key] ?? '' }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="alt_image">Mô Tả Hình Ảnh</label>
                                                                <input type="text" id="alt_image" name="alt_image[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ $certify_alt_image[$key] ?? '' }}" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="button_title">Button Tiêu Đề</label>
                                                                <input type="text" id="button_title" name="button_title[]" placeholder="Nhập button tiêu đề" class="form-control" value="{{ $certify_button_title[$key] ?? '' }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="button_link">Button Đường Dẫn</label>
                                                                <input type="text" id="button_link" name="button_link[]" placeholder="Nhập button đường dẫn" class="form-control" value="{{ $certify_button_link[$key] ?? '' }}">
                                                            </div>
                                                        </div>

                                                        @if( $key > 0 )
                                                            <div class="card-footer">
                                                                <div class="text-right">
                                                                    <button class="btn btn-sm btn-danger btn-remove-thumbnail" type="button">
                                                                        <i class="fas fa-trash"></i> Xóa
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            @endforeach

                                        @else
                                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                                <div class="card bg-light">
                                                    <div class="card-header text-muted border-bottom-0">
                                                        Hình Ảnh
                                                    </div>
                                                    <div class="card-body pt-0">
                                                        <div class="form-group">
                                                            <div id="holder" class="thumbnail text-center"></div>
                                                            <div class="input-group">
                                  <span class="input-group-btn">
                                    <a data-input="thumbnail" data-preview="holder" class="lfm-mul btn btn-primary">
                                      <i class="fa fa-picture-o"></i> Chọn Ảnh
                                    </a>
                                  </span>
                                                                <input id="thumbnail" class="form-control" type="text" name="images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="title_image">Tiêu Đề Hình Ảnh</label>
                                                            <input type="text" id="title_image" name="title_image[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="alt_image">Mô Tả Hình Ảnh</label>
                                                            <input type="text" id="alt_image" name="alt_image[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="button_title">Button Tiêu Đề</label>
                                                            <input type="text" id="button_title" name="button_title[]" placeholder="Nhập button tiêu đề" class="form-control" value="">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="button_link">Button Đường Dẫn</label>
                                                            <input type="text" id="button_link" name="button_link[]" placeholder="Nhập button đường dẫn" class="form-control" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="form-group text-right">
                                        @if( !empty( $certify_images ) && count( $certify_images ) > 0 )
                                            <button class="btn-clone-thumbnail btn btn-info" data-count="{{ count( $certify_images ) }}" type="button"><i class="fas fa-plus"></i> Thêm Hình Ảnh</button>
                                        @else
                                            <button class="btn-clone-thumbnail btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Hình Ảnh</button>
                                        @endif
                                    </div>

                                </div>
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
                    <a href="{{ route('certify.index') }}" class="btn btn-secondary">Thoát</a>
                </div>
            </div>
        </form>
        <!-- /.form -->
    </section>
    <!-- /.content -->

    <!-- Clone -->
    @include('backend.includes.clone-certify')

@endsection

