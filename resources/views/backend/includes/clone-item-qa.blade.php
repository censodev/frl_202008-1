<div class="clone-qa hide">
    <div class="row qa-item">
        <div class="col-md-6">
            <div class="form-group">
                <label for="descriptionSuggested">Câu trả lời</label>
                <textarea name="descriptionSuggested[]" class="form-control" rows="5" required placeholder="Nhập câu trả lời" oninvalid="this.setCustomValidity('Vui lòng nhập câu trả lời.')" oninput="setCustomValidity('')">
                </textarea>
            </div>
            <div class="form-group">
                <label for="dateCreatedSuggested">Ngày tạo</label>
                <input type="text" name="dateCreatedSuggested[]" value="{{ old('dateCreatedSuggested') }}" class="form-control form_datetime" required placeholder="Nhập ngày tạo" oninvalid="this.setCustomValidity('Vui lòng nhập ngày tạo.')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="upvoteCountSuggested">Số phiếu bình chọn</label>
                <input type="number" name="upvoteCountSuggested[]" value="{{ old('upvoteCountSuggested') }}" class="form-control" required placeholder="Nhập số phiếu bình chọn" oninvalid="this.setCustomValidity('Vui lòng nhập số phiếu bình chọn.')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="urlSuggested">Url câu trả lời</label>
                <input type="text" name="urlSuggested[]" value="{{ old('urlSuggested') }}" class="form-control" required placeholder="Nhập url câu trả lời" oninvalid="this.setCustomValidity('Vui lòng nhập url câu trả lời.')" oninput="setCustomValidity('')">
            </div>
            <div class="form-group">
                <label for="author_name_suggested">Tác giả</label>
                <input type="text" name="author_name_suggested[]" value="{{ old('author_name_suggested') }}" class="form-control" required placeholder="Nhập tên tác giả" oninvalid="this.setCustomValidity('Vui lòng nhập tên tác giả.')" oninput="setCustomValidity('')">
            </div>
        </div>
    </div>
</div>

