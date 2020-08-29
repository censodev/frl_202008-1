<div class="area-clone-album-hot-cli hide">
    <div class="col-12 col-sm-4 col-md-3 d-flex align-items-stretch clone-album-hot-cli">
        <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">
                Ảnh
            </div>
            <div class="card-body pt-0">
                <div class="form-group">
                    <label for="album_hot_title">Tiêu Đề</label>
                    <input type="text" id="album_hot_title" name="album_hot_title[]" placeholder="Nhập tiêu đề"
                        class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="album_hot_alt_images">Alt Image</label>
                    <input type="text" id="album_hot_alt_images" name="album_hot_alt_images[]" placeholder="Nhập alt" class="form-control" value="">
                </div>

                <div class="form-group">
                    <div id="holder-album-hot-number" class="thumbnail text-center"></div>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a data-input="thumbnail-album-hot-number" data-preview="holder-album-hot-number" class="lfm-mul btn btn-primary">
                            <i class="fa fa-picture-o"></i> Chọn Ảnh
                            </a>
                        </span>
                        <input id="thumbnail-album-hot-number" class="form-control" type="text" name="album_hot_images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button class="btn btn-sm btn-danger btn-remove-album-hot" type="button">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
