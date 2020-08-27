@if( !empty( $funfact_number ) || !empty( $funfact_icon ) || !empty( $funfact_description ))
<div class="ereaders-main-section ereaders-counterfull">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ereaders-counter bounceInDown wow">
                    <ul>
                        @if( !empty( $funfact_number ) )
                            @foreach( $funfact_number as $key => $ff_number )
                                <li>
                                    <div class="ereaders-counter-text">
                                        {!! $funfact_icon[$key] !!}
                                        <div class="ereaders-scroller"><h2 class="numscroller" data-slno="1" data-min="0" data-max="{{ $ff_number ?? 0 }}" data-delay="10" data-increment="9">{{ $ff_number ?? 0 }}</h2>
                                            <span>{!! $funfact_description[$key] ?? '' !!}</span>
                                        </div>
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
