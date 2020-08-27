<?php
$services_name = $data['services_name'];
$services_url = $data['services_url'];
$services_description = $data['services_description'];
?>
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Section Dịch Vụ Nổi Bật</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <div class="form-group">
                    <label for="title_service">Tiêu Đề</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input type="text" id="title_service" name="title_service" value="{{ $landingPage->title_service ?? old('title_service') }}" class="form-control" placeholder="Tiêu Đề">
                    </div>
                </div>

                <div id="holder-service" class="thumbnail holder-thumbnail text-center">
                    @if( !empty( $landingPage->images_service ) )
                        <img src="{{ $landingPage->images_service }}" style="height: 5rem;">
                    @endif
                </div>
                <div class="input-group">
			<span class="input-group-btn">
			  <a data-input="thumbnail-service" data-preview="holder-service" class="lfm-mul btn btn-primary">
				<i class="fa fa-picture-o"></i> Ảnh Nền
			  </a>
			</span>
                    <input id="thumbnail-service" class="form-control" type="text" name="images_service" value="{{ $landingPage->images_service }}">
                </div>
                <div class="form-group mt-3">
                    <label for="content_service">Nội Dung</label>
                    <textarea id="content_service" name="content_service" class="form-control ckeditor-lfm" rows="4">{!! $landingPage->content_service ?? old('content_service') !!}</textarea>
                </div>
                <div class="card card-solid mt-3">
                    <div class="card-header">
                        <h3 class="card-title">Dịch vụ nổi bật</h3>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row d-flex align-items-stretch increment-services">

                            @if( !empty( $services_name ) && count( $services_name ) > 0 )
                                @foreach( $services_name as $key => $s_name )
                                    @if (!empty($s_name))
                                        <div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch @if( $key > 0 ) clone-service-cli @endif ">
                                            <div class="card bg-light">
                                                <div class="card-body pt-0">
                                                    <div class="form-group">
                                                        <label for="services_name">Giá Trị</label>
                                                        <input type="text" id="services_name" name="services_name[]" placeholder="Nhập tiêu đề" class="form-control" value="{{ $s_name ?? '' }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="service_url">Url</label>
                                                        <input type="text" id="service_url" name="services_url[]" placeholder="Nhập link" class="form-control" value="{{ $services_url[$key] ?? '' }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="service_description">Mô Tả</label>
                                                        <textarea id="service_description" name="services_description[]" class="form-control" rows="4" placeholder="Nhập mô tả">{{ $services_description[$key] ?? '' }}</textarea>
                                                    </div>
                                                </div>

                                                @if( $key > 0 )
                                                    <div class="card-footer">
                                                        <div class="text-right">
                                                            <button class="btn btn-sm btn-danger btn-remove-service" type="button">
                                                                <i class="fas fa-trash"></i> Xóa
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>

                                    @endif
                                @endforeach
                            @else
                                <div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            Dịch vụ nổi bật
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="form-group">
                                                <label for="why_title">Giá Trị</label>
                                                <input type="text" id="why_title" name="services_name[]" placeholder="Nhập tiêu đề" class="form-control" value="">
                                            </div>

                                            <div class="form-group">
                                                <label for="service_url">Url</label>
                                                <input type="text" id="service_url" name="services_url[]" placeholder="Nhập link" class="form-control" value="">
                                            </div>

                                            <div class="form-group">
                                                <label for="service_description">Mô Tả</label>
                                                <textarea id="service_description" name="services_description[]" class="form-control" rows="4" placeholder="Nhập mô tả"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="form-group text-right">
                            <button class="btn-clone-services btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Dịch vụ nổi bật </button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->


<div class="clone-services-area hide">
    <div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch clone-service-cli">
        <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">
                Dịch vụ nổi bật
            </div>
            <div class="card-body pt-0">
                <div class="form-group">
                    <label for="why_title">Giá Trị</label>
                    <input type="text" id="why_title" name="services_name[]" placeholder="Nhập tiêu đề" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="service_url">Url</label>
                    <input type="text" id="service_url" name="services_url[]" placeholder="Nhập link" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="service_description">Mô Tả</label>
                    <textarea id="service_description" name="services_description[]" class="form-control" rows="4" placeholder="Nhập mô tả"></textarea>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button class="btn btn-sm btn-danger btn-remove-service" type="button">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
