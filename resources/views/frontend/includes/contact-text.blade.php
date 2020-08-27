@php
	$contact_info = json_decode( $contact->contact_info ) ?? array();
@endphp
<div class="section-heading">
	<h4>{{ $contact->title_contact_info }}</h4>
	<div class="section-heading-line-left"></div>
</div>
@if( !empty( $contact->description_info ) )
	<div class="text mb-20">
		{!! $contact->description_info !!}
	</div>
@endif
<div class="contact-info-box">
	<div class="row">
		@if( !empty( $contact_info[2] ) )
			<div class="col-lg-4 col-sm-12 col-12">
				<div class="contact-info-section">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-4 center-holder"> <i class="fa fa-phone"></i> </div>
						<div class="col-md-10 col-sm-10 col-8">
							<h4>Số điện thoại</h4>
							{{ $contact_info[2] }}
						</div>
					</div>
				</div>
			</div>
		@endif
		@if( !empty( $contact_info[1] ) )
			<div class="col-lg-4 col-sm-12 col-12">
				<div class="contact-info-section">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-4 center-holder"> <i class="fa fa-envelope-open"></i> </div>
						<div class="col-md-10 col-sm-10 col-8">
							<h4>Email</h4>
							{{ $contact_info[1] }}
						</div>
					</div>
				</div>
			</div>
		@endif
		@if( !empty( $contact_info[0] ) )
			<div class="col-lg-4 col-sm-12 col-12">
				<div class="contact-info-section">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-4 center-holder"> <i class="fa fa-globe"></i> </div>
						<div class="col-md-10 col-sm-10 col-8">
							<h4>Địa Chỉ</h4>
							{!! $contact_info[0] !!}
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
</div>