@if( !empty( $home_default->title_endow ) || !empty( $home_default->description_endow ) || !empty( $related_endows ))
<div class="ereaders-main-section ereaders-service-gridfull">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ereaders-fancy-title">
                    <h2 class="bounceIn wow">{{ $home_default->title_endow }}</h2>
                    <div class="clearfix"></div>
                    <div class="fadeInRight wow">
                        {!! $home_default->description_endow !!}
                    </div>
                </div>
                <div class="ereaders-service ereaders-service-grid fadeInUp wow">
                    <ul class="row">
                        @if(!empty($related_endows) && count($related_endows) > 0)
                            @foreach($related_endows as $key => $item)
                                    <li class="col-md-4">
                                        <div class="ereaders-service-grid-text">
                                            {!! $item->icon !!}
                                            <h5><a href="#">{{ $item->name }}</a></h5>
                                            {!! substr($item->description,0,160) !!}
                                        </div>
                                    </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

