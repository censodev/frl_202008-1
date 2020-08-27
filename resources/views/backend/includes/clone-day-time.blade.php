<div class="clone-day-time hide">
    <label>Ngày, giờ</label>
    <select class="form-control custom-select select-day-schema" name="day[]" multiple="multiple" required oninvalid="this.setCustomValidity('Vui lòng chọn ngày trong tuần.')" oninput="setCustomValidity('')">
        @foreach($week as $key => $day)
            <option value="{{ $key }}"> {{ $day }}</option>
        @endforeach
    </select>
    <div class="row">
        <div class="col-md-6">
            <label for="time_open">Giờ mở cửa</label>
            <input type="text" name="time_open[]" class="form-control time_open" required placeholder="Nhập giờ mở cửa" oninvalid="this.setCustomValidity('Vui lòng nhập giờ mở cửa.')" oninput="setCustomValidity('')">
        </div>
        <div class="col-md-6">
            <label for="time_close">Giờ đóng cửa</label>
            <input type="text" name="time_close[]"  class="form-control time_close" required placeholder="Nhập giờ đóng cửa" oninvalid="this.setCustomValidity('Vui lòng nhập giờ đóng cửa.')" oninput="setCustomValidity('')">
        </div>
    </div>
</div>
