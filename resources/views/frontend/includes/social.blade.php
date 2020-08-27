<div id="fb-root"></div>
<script>
   (function(d, s, id) {
    	var js, fjs = d.getElementsByTagName(s)[0];
    	if (d.getElementById(id)) return;
    	js = d.createElement(s); js.id = id;
    	js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId=';
    	fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

<div class="bottom-contact">
    <ul>
        @foreach($socials as $social)
            @if( $social->hide_social == 0 )
                @php
                    $link_social = $link_social_href = $icon_default_show = $color_icon_default = $social_icon_name = '';
                    $select_link = !empty( $social->select_link ) ? $social->select_link : 1;

                    switch( $select_link ) {
                        case 2:
                            $link_social = 'https://m.me/';
                            $icon_default_show = '<i class="fas fa-comment-lines"></i>';
                            $color_icon_default = 'social_ms';
                            $social_icon_name = 'social-icon-message-fb social-no-animate';
                            break;
                        case 3:
                            $link_social = 'https://zalo.me/';
                            $icon_default_show = '<img src="'. asset('assets/images/zalo.png') .'" title="Zalo" alt="Zalo">';
                            $color_icon_default = 'social_zl';
                            $social_icon_name = 'social-icon-zalo social-no-animate';
                            break;
                        case 4:
                            $link_social = '#lien-he';
                            $icon_default_show = '<i class="fas fa-edit"></i>';
                            $color_icon_default = 'social_ct';
                            $social_icon_name = 'social-icon-contact social-no-animate';
                            break;
                        case 5:
                            $link_social = 'tel:';
                            $icon_default_show = '<i class="fas fa-phone-alt"></i>';
                            $social_icon_name = 'social-icon-hotline';
                            break;
                        case 6:
                            $link_social = 'sms:';
                            $icon_default_show = '<i class="fas fa-sms"></i>';
                            $color_icon_default = 'social_sms';
                            $social_icon_name = 'social-icon-sms social-no-animate';
                            break;
                        case 7:
                            $icon_default_show = '<i class="fas fa-map-marked-alt"></i>';
                            $color_icon_default = 'social_ggm';
                            $social_icon_name = 'social-icon-ggm social-no-animate';
                        default :
                            $link_social = '';
                            $social_icon_name = 'social-no-animate';
                            break;
                    }

                    $link_social_href = $link_social . $social->link;

                    $img_url = $social->images ?? "";
                    $title 	 = $social->title_image ?? "";
                    $alt 	 = $social->alt_image ?? "";
                @endphp
                <li>
                    @if( !empty( $link_social_href ) && $link_social_href == '#lien-he' )
                        <a class="fb-chat btn-scroll-form {{ $social_icon_name }}" data-id="{{ $social->id }}" data-form="true" title="{{ $title }}">
                            @else
                                <a class="fb-chat {{ $social_icon_name }}" href="{{ $link_social_href }}" target="_blank" data-id="{{ $social->id }}" title="{{ $title }}">
                                    @endif
                                    <img src="{{ $img_url }}" height="50" width="50" style="z-index: 999999" title="{{ $title }}" alt="{{ $alt }}">
                                    <span>{{ $social->title }}</span>
                                </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
