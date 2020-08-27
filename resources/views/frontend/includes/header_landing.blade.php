@php
    $logo_top       = $logo->top->images ?? asset('assets/client/dist/images/logo-2.png');
    $title_image    = $logo->top->title_image ?? 'Logo Header';
    $alt_image      = $logo->top->alt_image ?? 'Logo Header';
	$route_search = route('search_all');
@endphp

<!-- Header Area Start Here -->
<header class="header">
	<div id="header-three" class="header-style-one header-fixed">
		<div class="header-top-bar bg-primary">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 col-md-12 col-sm-12 hidden--xs">
						<div class="header-contact-info">
							<ul>
								@if( !empty( $footer_contact_info ) && count( $footer_contact_info ) > 0 )
									@php
										$hotline = explode( ' - ', $footer_contact_info[3] );
									@endphp
									<li><i class="fa fa-phone" aria-hidden="true"></i>
										<a href="tel:{{ $hotline[0] }}" target="_blank" title="Hotline">{{ $hotline[0] }}</a> -
										<a href="tel:{{ $hotline[1] }}" target="_blank" title="Hotline">{{ $hotline[1] }}</a>
									</li>
									<li><i class="fa fa-location-arrow" aria-hidden="true"></i> {{ $footer_contact_info[1] }}</li>
								@endif
							</ul>
						</div>
					</div>
                    <div class="col-lg-4 col-md-4">
                        <div class="header-search">
                            <form id="top-search-form" action="{{ $route_search }}" method="GET">
                                <input type="text" name="query" class="search-input" placeholder="Tìm Kiếm...." required="">
                                <button class="search-button" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		<div class="main-menu-area bg-body" id="sticker">
			<div class="container">
				<div class="row d-md-flex align-items-md-center">
					<div class="col-lg-2 col-md-2">
						<div class="logo-area">
							<a href="{{ url('/') }}">
								<img src="{{ $logo_top }}" title="{{ $title_image }}" alt="{{ $alt_image }}" class="img-responsive" style="max-width: unset">
							</a>
						</div>
					</div>
					<div class="col-lg-10 col-md-10">
						<nav>
							<!-- Logo, Menu-->
							@include('frontend.includes.menu_landing')
							<!-- End Logo, Menu-->
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Mobile Menu Area Start -->
	<div class="mobile-menu-area">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="mobile-menu">
						<nav id="dropdown">
							<!-- Logo, Menu-->
							@include('frontend.includes.menu_landing')
							<!-- End Logo, Menu-->
						</nav>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Mobile Menu Area End -->
</header>
<!-- Header Area End Here -->
