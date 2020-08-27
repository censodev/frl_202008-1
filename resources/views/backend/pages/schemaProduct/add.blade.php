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
      <form role="form" action="{{ route('schema_product.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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
                              <input type="radio" name="status" value="1">
                              <label>Bật</label><br>
                              <input type="radio" name="status" value="0">
                              <label>Tắt</label><br>
                          </div>
                          <div class="form-group">
                              <label for="type">Chọn Sản Phẩm</label>
                              <select class="form-control" name="id_product" required oninvalid="this.setCustomValidity('Vui lòng chọn sản phẩm.')" oninput="setCustomValidity('')">
                                  <option disabled>--- Lựa Chọn ---</option>
                                  @foreach($data['list_product'] as $key => $product)
                                      <option value="{{ $product->id }}"> {{ $product->title }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="headline">Tên</label>
                              <input type="text" name="name" value="{{ old('name') }}" class="form-control" required placeholder="Nhập tên sản phẩm" oninvalid="this.setCustomValidity('Vui lòng nhập tên sản phẩm.')" oninput="setCustomValidity('')">
                          </div>
                          <div class="form-group">
                              <label>Mô tả</label>
                              <textarea name="description" class="form-control ckeditor" required placeholder="Nhập mô tả sản phẩm" oninvalid="this.setCustomValidity('Vui lòng nhập mô tả sản phẩm.')" oninput="setCustomValidity('')">
                                  {{ old('description') }}
                              </textarea>
                          </div>
                          <div class="form-group">
                              <label>Thương Hiệu</label>
                              <input type="text" name="brand" value="{{ old('brand') }}" class="form-control" required placeholder="Nhập tên thương hiệu" oninvalid="this.setCustomValidity('Vui lòng nhập tên thương hiệu.')" oninput="setCustomValidity('')">
                          </div>
                          <div class="form-group">
                              <label>Người review</label>
                              <input type="text" name="personReviewName" value="{{ old('personReviewName') }}" class="form-control" required placeholder="Nhập tên người review" oninvalid="this.setCustomValidity('Vui lòng nhập tên người review')" oninput="setCustomValidity('')">
                          </div>
                          <div class="form-group">
                              <label>Giá trị Review</label>
                              <input type="number" name="ratingValue" value="{{ old('ratingValue') }}" class="form-control" required placeholder="Nhập giá trị review" oninvalid="this.setCustomValidity('Vui lòng nhập giá trị review.')" oninput="setCustomValidity('')">
                          </div>
                          <div class="form-group">
                              <label>Giá trị Review tổng hợp</label>
                              <input type="text" name="ratingValueTotal" value="{{ old('ratingValueTotal') }}" class="form-control" required placeholder="Nhập giá trị review tổng hợp" oninvalid="this.setCustomValidity('Vui lòng nhập giá trị review tổng hợp.')" oninput="setCustomValidity('')">
                          </div>
                          <div class="form-grou   p">
                              <label>Tổng số review</label>
                              <input type="number" name="reviewCount" value="{{ old('reviewCount') }}" class="form-control" required placeholder="Nhập tổng số review" oninvalid="this.setCustomValidity('Vui lòng nhập tổng số review.')" oninput="setCustomValidity('')">
                          </div>
                          <div class="form-group">
                              <label>Đơn vị tiền tệ</label>
                              <input type="text" name="priceCurrency" value="{{ old('priceCurrency') }}" class="form-control" required placeholder="Nhập đơn vị tiền tệ" oninvalid="this.setCustomValidity('Vui lòng nhập đơn vị tiền tệ.')" oninput="setCustomValidity('')">
                          </div>
                          <div class="form-group">
                              <label>Giá</label>
                              <input type="text" name="price" value="{{ old('price') }}" class="form-control" required placeholder="Nhập giá" oninvalid="this.setCustomValidity('Vui lòng nhập giá.')" oninput="setCustomValidity('')">
                          </div>
                          <div class="form-group">
                              <label>Url Sản Phẩm</label>
                              <input type="text" name="product_url" value="{{ old('product_url') }}" class="form-control" required placeholder="Nhập url sản phẩm" oninvalid="this.setCustomValidity('Vui lòng nhập url sản phẩm.')" oninput="setCustomValidity('')">
                          </div>
                          <div class="form-group">
                              <label>Thời hạn giá cho đến</label>
                              <input type="text" name="datePrice" value="{{ old('datePrice') }}" class="form-control form_datetime" required placeholder="Nhập thời hạn giá" oninvalid="this.setCustomValidity('Vui lòng nhập thời hạn giá.')" oninput="setCustomValidity('')">
                          </div>
                          <div class="form-group">
                              <label>Công Ty, Doanh Nghiệp</label>
                              <input type="text" name="name_organization" value="{{ old('name_organization') }}" class="form-control" required placeholder="Nhập công ty, doanh nghiệp" oninvalid="this.setCustomValidity('Vui lòng nhập công ty, doanh nghiệp.')" oninput="setCustomValidity('')">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="row">
                              <div class="card-body pb-0">
                                  <div class="row d-flex align-items-stretch increment-thumbnail">
                                      <div class="col-md-12 d-flex align-items-stretch">
                                          <div class="card bg-light box-image-chema">
                                              <div class="card-header text-muted border-bottom-0">
                                                  Hình Ảnh
                                              </div>
                                              <div class="card-body pt-0">
                                                  <div class="form-group">
                                                      <div id="holder" class="thumbnail text-center">
                                                          <img src="" style="height: 5rem;">
                                                      </div>
                                                      <div class="input-group">
                                                        <span class="input-group-btn">
                                                          <a data-input="thumbnail" data-preview="holder" class="lfm-mul btn btn-primary">
                                                            <i class="fa fa-picture-o"></i> Chọn Ảnh
                                                          </a>
                                                        </span>
                                                          <input id="thumbnail" value="" class="form-control" type="text" name="images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group text-right">
                                      <button class="btn-clone-thumbnail btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Hình Ảnh</button>
                                  </div>
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
            <a href="{{ route('schema_product.index') }}" class="btn btn-secondary">Thoát</a>
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->

    @include('backend.includes.clone-image-schema')
@endsection
