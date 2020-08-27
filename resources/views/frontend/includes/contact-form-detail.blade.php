<div class="col-lg-6" style="margin: 30px auto;">
    <label>LIÊN HỆ TƯ VẤN NGAY</label>
    <form id="contact-form" action="{{ route('contact_submit') }}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="alias_contact" value="{{ url()->current() }}">
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-form-style mb-20">
                    <input name="fullname" placeholder="Họ tên" type="text">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-form-style mb-20">
                    <input name="phone" placeholder="Số điện thoại" type="text">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="contact-form-style">
                    <textarea name="message" placeholder="Lời nhắn" rows"5"></textarea>
                    <button class="submit" type="submit">Gửi</button>
                </div>
            </div>
        </div>
    </form>
</div>
