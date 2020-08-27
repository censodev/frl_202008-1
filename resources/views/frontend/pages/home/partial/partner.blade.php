@if( !empty( $related_partners ) && count( $related_partners ) > 0 )
<div class="ereaders-main-section ereaders-partner-sliderfull">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ereaders-fancy-title">
                    <h2 class="bounceIn wow">{{ $home_default->title_partner }}</h2>
                    <div class="clearfix"></div>
                    <div class="fadeInRight wow">
                        {!! $home_default->description_partner !!}
                    </div>
                </div>
                <div class="ereaders-partner-slider fadeInUp wow">
                    @foreach( $related_partners as $partner )
                        @php
                            $images = $partner->images ?? asset('assets/admin/dist/img/no_image.png');
                            $link_title   = !empty( $partner->link_title ) ? $partner->link_title : $partner->name;
                            $title_image  = !empty( $partner->title_image ) ? $partner->title_image : $partner->name;
                            $alt_image    = !empty( $partner->alt_image ) ? $partner->alt_image : $partner->name;
                        @endphp
                        <div class="ereaders-partner-slider-layer"> <a href="{{ $images }}" title="{{ $title_image }}" class="fancybox"><img src="{{ $images }}" title="{{ $title_image }}" alt="{{ $alt_image }}"></a> </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif


