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
      $configPolicy     = $data['configPolicy'];
      
	  $policy_title         = json_decode( $configPolicy->policy_title );
      $policy_icon         = json_decode( $configPolicy->policy_icon );
      $policy_description    = json_decode( $configPolicy->policy_description );

      $count_policy_title = $count_policy_icon = $count_policy_description = 0;
      if( !empty( $policy_title ) && count( $policy_title ) > 0 ) {
        $count_policy_title = count( $policy_title );
      }

      if( !empty( $policy_icon ) && count( $policy_icon ) > 0 ) {
        $count_policy_icon = count( $policy_icon );
      }

      if( !empty( $policy_description ) && count( $policy_description ) > 0 ) {
        $count_policy_description = count( $policy_description );
      }

      $count_policy = max($count_policy_title, $count_policy_icon, $count_policy_description);
    @endphp

    <!-- Main content -->
    <section class="content">
      <form role="form" action="{{ route('configPolicy.update',$configPolicy->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $configPolicy->id }}">
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
                  <input type="text" id="title" name="title" value="{{ $configPolicy->title ?? old('title') }}" class="form-control" required placeholder="Nhập tiêu đề" oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                  @if( $errors->has('title') )
                    <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                  @endif
                </div>
				
				<div class="form-group">
					<label for="policy_sales">Chính Sách Bán Hàng</label>
					<textarea id="policy_sales" name="policy_sales" class="form-control ckeditor-lfm" rows="4">{!! $configPolicy->policy_sales ?? old('policy_sales') !!}</textarea>
				</div>
				
				<div class="form-group">
					<label for="policy_delivery">Chính Sách Giao Hàng</label>
					<textarea id="policy_delivery" name="policy_delivery" class="form-control ckeditor-lfm" rows="4">{!! $configPolicy->policy_delivery ?? old('policy_delivery') !!}</textarea>
				</div>

                <!-- Default box -->
				  <div class="card card-solid mt-3">
					<div class="card-header">
					  <h3 class="card-title">Chính Sách</h3>
					</div>
					<div class="card-body pb-0">
					  <div class="row d-flex align-items-stretch increment-funfact">

						@if( !empty( $count_policy ) )
						  @foreach( $policy_title as $key => $pl_title )

							<div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch @if( $key > 0 ) clone-funfact-cli @endif ">
							  <div class="card bg-light">
								<div class="card-header text-muted border-bottom-0">
								  Số Liệu
								</div>
								<div class="card-body pt-0">
								  <div class="form-group">
									<label for="policy_title">Tiêu Đề</label>
									<input type="text" id="policy_title" name="policy_title[]" placeholder="Nhập tiêu đề" class="form-control" value="{{ $pl_title ?? '' }}">
								  </div>

								  <div class="form-group">
									<label for="policy_icon">Icon</label>
									<input type="text" id="policy_icon" name="policy_icon[]" placeholder="Nhập icon" class="form-control" value="{{ $policy_icon[$key] ?? '' }}">
								  </div>

								  <div class="form-group">
									<label for="policy_description">Mô Tả</label>
									<textarea id="policy_description" name="policy_description[]" class="form-control" rows="4" placeholder="Nhập mô tả">{{ $policy_description[$key] ?? '' }}</textarea>
								  </div>
								</div>

								@if( $key > 0 )
								  <div class="card-footer">
									<div class="text-right">
									  <button class="btn btn-sm btn-danger btn-remove-funfact" type="button">
										<i class="fas fa-trash"></i> Xóa
									  </button>
									</div>
								  </div>
								@endif

							  </div>
							</div>

						  @endforeach
						@else
						  <div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch">
							<div class="card bg-light">
							  <div class="card-header text-muted border-bottom-0">
								Chính sách
							  </div>
							  <div class="card-body pt-0">
								<div class="form-group">
								  <label for="policy_title">Tiêu Đề</label>
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
						@endif

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