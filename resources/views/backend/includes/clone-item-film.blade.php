<div class="area-clone-thumbnail-cli hide">
  <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch clone-thumbnail-cli">
    <div class="card bg-light">
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