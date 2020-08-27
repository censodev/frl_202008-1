@if( !empty( $related_banners ) && count( $related_banners ) > 0 )
<div class="banner-area">
    <div class="container">
        <div class="banner-area-active owl-carousel ptb-60">
            @foreach( $related_banners as $banner )
                @php
                    $images = $banner->images ?? asset('assets/admin/dist/img/no_image.png');
                    $link_title   = !empty( $banner->link_title ) ? $banner->link_title : $banner->name;
                    $title_image  = !empty( $banner->title_image ) ? $banner->title_image : $banner->name;
                    $alt_image    = !empty( $banner->alt_image ) ? $banner->alt_image : $banner->name;
                @endphp
                <div class="single-banner-area">
                    <img alt="{{ $alt_image }}" title="{{ $title_image }}" src="{{ $images }}">
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
