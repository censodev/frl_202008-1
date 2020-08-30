<div class="area-clone-section-cli hide">
    <div class="col-12 col-sm-12 col-md-12 align-items-stretch clone-section-cli section-item">
        <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">
                Section
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <input type="hidden" value="" name="item_id[]">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" name="name[]" placeholder="Nhập tiêu đề" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Chọn loại modules</label>
                            <select name="type[]" class="form-control" required>
                                <option value="">---chọn loại---</option>
                                @foreach($types as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Thứ tự</label>
                            <input type="number" name="ordering[]" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div id="holder-number" class="thumbnail thumbnail-clone text-center"></div>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a data-input="thumbnail-number" data-preview="holder-number" class="lfm-mul btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Chọn Ảnh Desktop
                                  </a>
                                </span>
                                <input id="thumbnail-number" class="form-control" type="text" name="images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title_image">Tiêu Đề Hình Ảnh Desktop</label>
                            <input type="text" id="title_image" name="title_image[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                        </div>

                        <div class="form-group">
                            <label for="alt_image">Mô Tả Hình Ảnh Desktop</label>
                            <input type="text" id="alt_image" name="alt_image[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div id="holder_mobile-number" class="thumbnail thumbnail-clone text-center"></div>
                            <div class="input-group">
                                <span class="input-group-btn">
                                  <a data-input="thumbnail_mobile-number" data-preview="holder_mobile-number" class="lfm-mul btn btn-primary">
                                    <i class="fa fa-picture-o"></i> Chọn Ảnh Mobile
                                  </a>
                                </span>
                                <input id="thumbnail_mobile-number" class="form-control" type="text" name="images_mobile[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title_image">Tiêu Đề Hình Ảnh Mobile</label>
                            <input type="text" name="title_image_mobile[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                        </div>

                        <div class="form-group">
                            <label for="alt_image">Mô Tả Hình Ảnh Mobile</label>
                            <input type="text" name="alt_image_mobile[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Chi Tiết</label>
                            <textarea  name="description[]" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 list-value">
                        <div class="form-group block-search-appliesto">
                            <button class="btn btn-info " disabled type="button" data-toggle="modal" data-target="" search="" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
                        </div>
                        <div class="form-group">
                            <ul class="todo-list appliesto-value" data-widget="todo-list">

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button class="btn btn-sm btn-danger btn-remove-section" type="button">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
