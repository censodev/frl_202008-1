@php
    $footer_title           = !empty( $footers->footer_title ) ? json_decode( $footers->footer_title ) : [];
    $footer_description     = !empty( $footers->footer_description ) ? json_decode( $footers->footer_description ) : [];
    $footer_contact_info    = !empty( $footers->footer_contact_info ) ? json_decode( $footers->footer_contact_info ) : [];

    $logo_footer             = $logo->footer->images ?? asset('assets/client/dist/images/footer-logo.png');
    $title_image             = $logo->footer->title_image ?? 'Logo Footer';
    $alt_image               = $logo->footer->alt_image ?? 'Logo Footer';

    if( ( !empty( $footer_title[2] ) || !empty( $footer_description[2] ) ) && ( !empty( $footer_title[3] ) || !empty( $footer_description[3] ) ) ) {
        $class_col = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
        $class_col_hide = '';
    }else {
        $class_col = 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
        $class_col_hide = 'hide';
    }

@endphp
<footer id="ereaders-footer" class="ereaders-footer-one">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget mb-40">
                    <div class="footer-title mb-30">
                        @if( !empty( $footer_title[0] ) )
                            <h3>{{ $footer_title[0] }}</h3>
                        @endif
                    </div>
                    <div class="footer-about">
                        @if( !empty( $footer_description[0] ) )
                            {!! $footer_description[0] !!}
                        @endif
                    </div>
                    <div class="social-icon mr-40">
                        <ul>
                            @if( !empty( $socials_topbar ) && count( $socials_topbar ) > 0 )
                                @foreach( $socials_topbar as $social_tb )
                                    @php
                                        $link = $social_tb->link ?? '#';
                                    @endphp
                                    @if( $social_tb->hide_social != 1 )
                                        <li>
                                            <a href="{!! $link !!}" title="{!! $link !!}" target="_blank" class="{{ strtolower($social_tb->title) }}">
                                                {!! $social_tb->icon !!}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget mb-40">
                    <div class="footer-title mb-30">
                        @if( !empty( $footer_title[1] ) )
                            <h3>{{ $footer_title[1] }}</h3>
                        @endif
                    </div>
                    <div class="footer-contact">
                        <ul>
                            @if( !empty( $footer_contact_info[0] ) )
                                <li><i class="fa fa-map-marker" aria-hidden="true"></i> Địa chỉ : {{ $footer_contact_info[0] }}</li>
                            @endif
                            @if( !empty( $footer_contact_info[3] ) )
                                <li><i class="fa fa-phone" aria-hidden="true"></i> Hotline :  {{ $footer_contact_info[3] }}</li>
                            @endif
                            @if( !empty( $footer_contact_info[1] ) )
                                <li><i class="fa fa-envelope-o" aria-hidden="true"></i> Email :  {{ $footer_contact_info[1] }}</li>
                            @endif
                            @if( !empty( $footer_contact_info[2] ) )
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> Mở cửa :  {{ $footer_contact_info[2] }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget mb-40">
                    <div class="footer-title mb-30">
                        @if( !empty( $footer_title[2] ) )
                            <h3>{{ $footer_title[2] }}</h3>
                        @endif
                    </div>
                    <div class="footer-content">
                        @if( !empty( $footer_description[2] ) )
                            {!! $footer_description[2] !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if( !empty( $footers->footer_copyright ) )
        <div class="footer-bottom black-bg-2 pb-30 pt-25">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="copyright text-center">
                            {!! $footers->footer_copyright !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</footer>

<div class="add-cart-success" id="add-cart-success">
    <i class="fa fa-cart-arrow-down cart-bag" aria-hidden="true"></i> Thêm thành công vào giỏ hảng
</div>

@if( !empty( $scripts->script_footer ) )
    {!! $scripts->script_footer !!}
@endif

@if(!empty($seeding) && count($seeding) > 0)

    <div class="notneva" id="notineva">
        {{--        <div class="notifi display" id="noti"> <div class="item"> <div class="img-noti"><img src="http://ereader.test/storage/files/1/Seeding/khach-hang-1.jpg" alt="" width="50px"></div> <div class="content"> <p class="name">Phạm Hồng Anh</p><span style="font-style: italic;">Đã đặt lịch tư vấn</span> <p class="time">8 phút trước</p> </div> </div>--}}
    </div>

    <script>
        var noti = document.getElementById('notineva');
        var test = document.getElementById('noti');
        var arr = @json($array_seeding);
        function random(array) {
            return array[Math.floor(Math.random() * array.length)]
        }
        setInterval(function(){
            noti.innerHTML = random(arr);
            setTimeout(function(){
                noti.classList.add('hidden');
            },10000);
            setTimeout(function(){
                noti.classList.remove('hidden');
            },5000);
        },10000);
    </script>

@endif
