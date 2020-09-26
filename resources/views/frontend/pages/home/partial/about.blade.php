<div class="ereaders-main-section ereaders-product-gridfull" style="background:#fff">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ereaders-fancy-title" style="margin-bottom:30px">
                    <h2 class="bounceIn wow">
                        {{ $home_default->title_about }}
                    </h2>
                    <div class="clearfix"></div>
                    <div class="fadeInRight wow">
                        {!! $home_default->title_image_about !!}
                    </div>
                </div>
                <div class="ereaders-shop ereaders-shop-grid fadeInUp wow">
                    <div class="row d-flex" style="{{ $home_default->position_about == 1 ? 'flex-direction: row-reverse;' : '' }}">
                        <div class="col-md-6 col-sm-12">
                            {!! $home_default->content_about !!}
                        </div>
                        <div class="col-md-6 col-sm-12">
                            @if ($home_default->images_about)
                                <img class="w-100" src="{{ $home_default->images_about }}"
                                    alt="{{ $home_default->alt_image_about }}" 
                                    title="{{ $home_default->title_image_about }}">
                            @else
                                {!! $home_default->video_embed_about !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
