@if( !empty( $contact->title_contact ) || !empty( $contact->description ) )
<div class="section-title-dark">
	@if( !empty( $contact->title_contact ) )
		<h2>{{ $contact->title_contact }}</h2>
		<span><i class="fa fa-circle-o" aria-hidden="true"></i></span>
	@endif
</div>
@endif

<form id="contact-form" class="contact-form" method="post" action="{{ route('contact_submit') }}" method="POST" accept-charset="UTF-8">
	{{csrf_field()}}
	<input type="hidden" name="alias_contact" value="{{ url()->current() }}">
	<fieldset>
		<div class="row">
			<div class="col-lg-offset-2 col-md-offset-2 col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
						<div class="form-group">
							<input type="text" placeholder="Họ Và Tên" class="form-control" name="fullname" id="form-name" data-error="Vui lòng nhập họ tên." required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
						<div class="form-group">
							<input type="email" placeholder="Email" class="form-control" name="email" id="form-email">
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
						<div class="form-group">
							<input type="text" placeholder="Số điện thoại" class="form-control" name="phone" id="form-phone" data-error="Vui lòng nhập số điện thoại." required>
							<div class="help-block with-errors"></div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-sm-12">
						<div class="form-group">
							<input type="text" placeholder="Địa chỉ" class="form-control" name="address" id="form-address">
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<textarea placeholder="Nội dung" class="textarea form-control" name="message" id="form-message" rows="7" cols="20"></textarea>
						</div>
					</div>
					<div class="btn-css text-center">
						<button type="submit" class="btn-fill-primary2 mt-30">Gửi</button>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-sm-12 hide">
						<div class='form-response'></div>
					</div>
				</div> 
			</div>
		</div>
	</fieldset>
</form>
