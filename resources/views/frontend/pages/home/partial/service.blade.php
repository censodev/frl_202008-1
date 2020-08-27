@if( !empty( $home_default->title_service ) || !empty( $home_default->content_service ) || !empty( $services_name ))
    <div class="ereaders-main-section ereaders-service-providefull">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ereaders-fancy-title">
                    <h2 class="bounceIn wow">{{ $home_default->title_service }}</h2>
                    <div class="clearfix"></div>
                    <div class="fadeInRight wow">
                        {!! $home_default->content_service !!}
                    </div>
                </div>
            </div>
            <aside class="col-md-12">
                <div class="ereaders-service ereaders-service-list fadeInUp wow">
                    <ul class="row">
                        @if(!empty($services_name) && count($services_name) > 0)
                            @foreach($services_name as $key => $item)
                                @if($item != null)
                                    <li class="col-md-4">
                                        {!! $services_url[$key] !!}
                                        <h5><a href="#">{{ $item }}</a></h5>
                                        {!! substr($services_description[$key],0,150) !!}
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</div>
    @endif

