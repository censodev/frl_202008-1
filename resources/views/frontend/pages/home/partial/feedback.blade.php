@if( !empty( $feedbacks ) || !empty($home_default->title_feedback) )
    <div class="ereaders-main-section ereaders-testimonialfull">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="ereaders-testimonial">
                    <div class="ereaders-testimonial-wrap">
                        <div class="ereaders-fancy-title bounceIn wow"><h2>{{ $home_default->title_feedback }}</h2></div>
                        <div class="ereaders-testimonial-slide fadeInUp wow">

                            @if( !empty( $feedbacks ) && count( $feedbacks ) > 0 )
                                @foreach( $feedbacks as $feedback )
                                    @php
                                        $images = !empty( $feedback->images ) ? $feedback->images : asset('assets/admin/dist/img/avatar5.png');
                                    @endphp
                                    <div class="ereaders-testimonial-slide-layer">
                                        <figure><img src="{{ $images }}" title="{{ $feedback->title_image }}" alt="{{ $feedback->alt_image }}"></figure>
                                        <div class="ereaders-testimonial-text">
                                            <h4>{{ $feedback->name_customer }}</h4>
                                            <span>{{ $feedback->position }}</span>
                                            {!! $feedback->description !!}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
