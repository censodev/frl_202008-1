@if( !empty( $home_default->title_team ) || ( !empty( $related_teams ) && count( $related_teams ) > 0 ) )
	@if( !empty( $home_default->images_team ) )
        <style type="text/css">
            section.team-section {
                background-image: url('{{ $home_default->images_team  }}');
            }
        </style>
    @endif
<section class="team-section section-i-bg">
    <div class="container">
		<div class="section-heading center-holder">
            @if( !empty( $home_default->title_team ) )
                <h2>{{ $home_default->title_team }}</h2>
                <div class="section-heading-line"></div>
            @endif
            <p>{!! $home_default->content_team ?? '' !!}</p>
        </div>

        <div class="row mt-20">

            @if( !empty( $related_teams ) && count( $related_teams ) > 0 )
                @foreach( $related_teams as $team )
                    @php
                        $images = $team->images ?? asset('assets/admin/dist/img/no_image.png');
                        $socials = json_decode( $team->social );
                    @endphp
                    <!-- Team Block -->
                    <div class="team-block col-lg-3 col-md-6 col-sm-12 text-center">
                        <div class="inner-box">
                            <div class="image-box">
                                <div class="image"><a href="team.html"><img src="{{ $images }}" title="{{ $team->title_image ?? $team->name }}" alt="{{ $team->alt_image ?? $team->name }}"></a></div>
                                @if( !empty( $team->social ) )
                                    <ul class="social-links">
                                        @foreach( $socials as $key => $social )
                                            @if( $social )
                                                <li>
                                                    <a href="{{ $social }}">
                                                        @php
                                                            switch( $key ) {
                                                            case 1:
                                                                echo '<i class="fa fa-facebook"></i>';
                                                                break;
                                                            case 2:
                                                                echo '<i class="fa fa-twitter"></i>';
                                                                break;
                                                            case 3:
                                                                echo '<i class="fa fa-google-plus"></i>';
                                                                break;
                                                            case 4:
                                                                echo '<i class="fa fa-instagram"></i>';
                                                                break;
                                                            default:
                                                                echo '<i class="fa fa-whatsapp"></i>';
                                                                break;
                                                        }
                                                        @endphp
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                                <h3 class="name"><a href="#">{{ $team->name }}</a></h3>
                            </div>
                            <span class="designation">{{ $team->position }}</span>
							<div class="team-description">{!! $team->description !!}</div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</section>
@endif