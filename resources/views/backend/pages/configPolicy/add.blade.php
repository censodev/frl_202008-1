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
      <form role="form" action="{{ route('configPolicy.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
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

                <div class="form-group">
                  <label for="title">Tiêu đề</label>
                  <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" required placeholder="Nhập tiêu đề" oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                  @if( $errors->has('title') )
                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                  @endif
                </div>
				
				<div class="form-group">
					<label for="policy_sales">Chính Sách Bán Hàng</label>
					<textarea id="policy_sales" name="policy_sales" class="form-control ckeditor-lfm" rows="4">{!! old('policy_sales') !!}</textarea>
				</div>
				
				<div class="form-group">
					<label for="policy_delivery">Chính Sách Giao Hàng</label>
					<textarea id="policy_delivery" name="policy_delivery" class="form-control ckeditor-lfm" rows="4">{!! old('policy_delivery') !!}</textarea>
				</div>

                <!-- Default box -->
				  <div class="card card-solid mt-3">
					<div class="card-header">
					  <h3 class="card-title">Chính Sách</h3>
					</div>
					<div class="card-body pb-0">
					  <div class="row d-flex align-items-stretch increment-funfact">

						<div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch">
						  <div class="card bg-light">
							<div class="card-header text-muted border-bottom-0">
							  Chính Sách
							</div>
							<div class="card-body pt-0">
							  <div class="form-group">
								<label for="policy_title">Tiểu Đề</label>
								<input type="text" id="policy_title" name="policy_title[]" placeholder="Nhập tiêu đề" class="form-control" value="">
							  </div>

							  <div class="form-group">
								<label for="policy_icon">Icon</label>
								<input type="text" id="policy_icon" name="policy_icon[]" placeholder="Nhập icon" class="form-control" value="">
							  </div>

							  <div class="form-group">
								<label for="policy_description">Mô Tả</label>
								<textarea id="policy_description" name="policy_description[]" class="form-control" rows="4" placeholder="Nhập mô tả"></textarea>
							  </div>
							</div>
						  </div>
						</div>

					  </div>

					  <div class="form-group text-right">
						<button class="btn-clone-funfact btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Số Liệu</button>
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
          <div class="col-12">
            <a href="{{ route('configPolicy.index') }}" class="btn btn-secondary hide">Thoát</a>
            <input type="submit" value="Lưu" class="btn btn-success float-right">
          </div>
        </div>
      </form>
      <!-- /.form -->
    </section>
    <!-- /.content -->
	
	<!-- Clone -->
    @include('backend.includes.clone-policy')
	
@endsection