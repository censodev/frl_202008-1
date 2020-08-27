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
        $schema     = $data['schema'];
        $shows = unserialize($schema->shows);
        $names      = unserialize($schema->name);
        $urls       = unserialize($schema->url);
        $list_post          = $data['list_post'];
        $list_product       = $data['list_product'];
        $list_product_cat   = $data['list_product_cat'];
        $list_post_cat      = $data['list_post_cat'];
    @endphp

    <!-- Main content -->
    <section class="content">
      <form role="form" action="{{ route('schema_breadcrumb.update',$schema->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        @method('PUT')
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
                                    <label for="type">Tên</label>
                                    <input type="text" class="form-control" name="name_breadcrumb" value="{{ $schema->name_breadcrumb ?? old($schema->name_breadcrumb) }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tên breadcrumb.')" oninput="setCustomValidity('')">
                                </div>
                                <div class="form-group">
                                    <input type="radio" name="status" value="1" @if(!empty($schema) && ($schema->status == 1)) checked @endif>
                                    <label>Bật</label><br>
                                    <input type="radio" name="status" value="0" @if(!empty($schema) && ($schema->status == 0)) checked @endif>
                                    <label>Tắt</label><br>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Chọn Loại Breadcrumb</label>
                                            <select class="form-control" name="type"oninvalid="this.setCustomValidity('Vui lòng chọn loại breadcrumb.')" oninput="setCustomValidity('')">
                                                <option selected>--- Lựa Chọn Loại Breadcrumb ---</option>
                                                @foreach($data['show_where'] as $key => $show)
                                                    <option @if($schema->type == $key) selected @endif value="{{ $key }}"> {{ $show }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Chọn Bài Viết</label>
                                            <select class="form-control" name="id_post" oninvalid="this.setCustomValidity('Vui lòng chọn bài viết.')" oninput="setCustomValidity('')">
                                                <option selected>--- Lựa Chọn Bài Viết---</option>
                                                @foreach($list_post as $key => $post)
                                                    <option value="{{ $post->id }}" @if($schema->id_post == $post->id) selected @endif> {{ $post->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Chọn Sản Phẩm</label>
                                            <select class="form-control" name="id_product" oninvalid="this.setCustomValidity('Vui lòng chọn sản phẩm.')" oninput="setCustomValidity('')">
                                                <option selected>--- Lựa Chọn Sản Phẩm---</option>
                                                @foreach($list_product as $key => $product)
                                                    <option value="{{ $product->id }}" @if($schema->id_product == $product->id) selected @endif> {{ $product->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Chọn Danh Mục Sản Phẩm</label>
                                            <select class="form-control" name="id_product_cat" oninvalid="this.setCustomValidity('Vui lòng chọn danh mục sản phẩm.')" oninput="setCustomValidity('')">
                                                <option selected>--- Lựa Chọn Sản Phẩm ---</option>
                                                @foreach($list_product_cat as $key => $product_cat)
                                                    <option value="{{ $product_cat->id }}" @if($schema->id_product_cat == $product_cat->id) selected @endif> {{ $product_cat->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="type">Chọn Danh Mục Bài Viết</label>
                                            <select class="form-control" name="id_post_cat" oninvalid="this.setCustomValidity('Vui lòng chọn danh mục bài viết.')" oninput="setCustomValidity('')">
                                                <option selected>--- Lựa Chọn Bài Viết ---</option>
                                                @foreach($list_post_cat as $key => $post_cat)
                                                    <option value="{{ $post_cat->id }}" @if($schema->id_post_cat == $post_cat->id) selected @endif> {{ $post_cat->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-success add-breadcrum">Thêm</button>
                                </div>
                                @if(!empty($names) && count($names) > 0)
                                    <div class="list-breadcrum">
                                        @foreach($names as $key => $item)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="type">Name</label>
                                                    <input type="text" class="form-control" name="name[]" value="{{$item ?? old('name') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="type">Url</label>
                                                    <input type="text" class="form-control" name="url[]" value="{{$urls[$key] ?? old('url') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập url.')" oninput="setCustomValidity('')">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="list-breadcrum">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="type">Name</label>
                                                <input type="text" class="form-control" name="name[]" value="{{ old('name') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="type">Url</label>
                                                <input type="text" class="form-control" name="url[]" value="{{ old('url') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập url.')" oninput="setCustomValidity('')">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="type">Name</label>
                                        <input type="text" class="form-control" name="name_last" value="{{ $schema->name_last ?? old('name_last') }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
                                    </div>
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
            <a href="{{ route('schema_breadcrumb.index') }}" class="btn btn-secondary">Thoát</a>
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
    @include('backend.includes.clone-item-breadcrumb')
@endsection
