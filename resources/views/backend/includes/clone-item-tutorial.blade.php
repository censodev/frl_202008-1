<div class="clone-tutorial hide">
    <div class="row tutorial-item">
        <div class="col-md-6">
            <div class="form-group">
                <label>Tên</label>
                <input type="text" name="name_step[]" value="" class="form-control" required placeholder="Nhập tên" oninvalid="this.setCustomValidity('Vui lòng nhập tên.')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label>Url</label>
                <input type="text" name="url_step[]" value="" class="form-control" required placeholder="Nhập url" oninvalid="this.setCustomValidity('Vui lòng nhập url.')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label>Bước 1</label>
                <input type="text" name="step_one[]" value="" class="form-control" required placeholder="Nhập bước 1" oninvalid="this.setCustomValidity('Vui lòng nhập bước 1.')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label>Bước 2</label>
                <input type="text" name="step_two[]" value="" class="form-control" required placeholder="Nhập bước 2" oninvalid="this.setCustomValidity('Vui lòng nhập bước 2.')" oninput="setCustomValidity('')">
            </div>
            <div id="holder" class="thumbnail text-center">
            </div>
            <div class="input-group">
                  <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                      <i class="fa fa-picture-o"></i>Hình ảnh
                    </a>
                  </span>
                <input id="thumbnail" class="form-control" type="text" required name="image_step[]" value="" required oninvalid="this.setCustomValidity('Vui lòng chọn ảnh.')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label>Chiều rộng ảnh</label>
                <input type="text" name="width_image_step[]" value="" class="form-control" required placeholder="Nhập chiều rộng ảnh" oninvalid="this.setCustomValidity('Vui lòng nhập chiều rộng ảnh.')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label>Chiều cao ảnh</label>
                <input type="text" name="height_image_step[]" value="" class="form-control" required placeholder="Nhập chiều cao ảnh" oninvalid="this.setCustomValidity('Vui lòng nhập chiều cao ảnh.')" oninput="setCustomValidity('')">
            </div>
        </div>
    </div>
</div>

