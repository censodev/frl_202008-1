<div class="area-clone-thumbnail-cli hide">
    <div class="col-md-12 d-flex align-items-stretch clone-thumbnail-cli">
        <div class="card bg-light box-image-chema">
            <div class="card-header text-muted border-bottom-0">
                Hình Ảnh
            </div>
            <div class="card-body pt-0">
                <div class="form-group">
                    <div id="holder-number" class="thumbnail thumbnail-clone text-center"></div>
                    <div class="input-group">
                        <span class="input-group-btn">
                          <a data-input="thumbnail-number" data-preview="holder-number" class="lfm-mul btn btn-primary">
                            <i class="fa fa-picture-o"></i> Chọn Ảnh
                          </a>
                        </span>
                        <input id="thumbnail-number" class="form-control" type="text" name="images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button class="btn btn-sm btn-danger btn-remove-thumbnail" type="button">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
