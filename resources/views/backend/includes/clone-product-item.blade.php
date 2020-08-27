<div class="area-clone-product-cli hide">
    <div class="col-12 col-sm-12 col-md-12 align-items-stretch clone-product-cli">
        <div class="card bg-light">
            <div class="card-header text-muted border-bottom-0">
                Sản Phẩm
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <input type="hidden" value="" name="item_id[]">
                    <div class="col-md-4">
                        <label>Vật liệu</label>
                        <select class="form-control" name="material[]">
                            <option value="">Chọn chất liệu</option>
                            @foreach($material as $key => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Giá bán</label>
                            <input type="text" name="price_buy[]" placeholder="Nhập giá" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập giá.')" oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Giá khuyến mãi</label>
                            <input type="text" name="price_promotion[]" placeholder="Nhập giá khuyến mãi" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập giá khuyến mãi.')" oninput="setCustomValidity('')">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <button class="btn btn-sm btn-danger btn-remove-product" type="button">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
