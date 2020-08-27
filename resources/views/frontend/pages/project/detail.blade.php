@extends($data->layout)

@section('title')
    {{ $data->title }}
@endsection

@section($data->content)

	<!--Project Detail Section-->
    <section class="project-details-section">
        <div class="project-detail">
            <div class="auto-container">
                <!-- Upper Box -->
                <div class="upper-box">
                    <!--Project Tabs-->
                    <div class="project-tabs tabs-box clearfix">
                        <!--Tab Btns-->
                        <ul class="tab-btns tab-buttons clearfix">
                            <li data-tab="#tab-1" class="tab-btn active-btn"><img src="{{ asset('assets/client/dist/images/resource/project-thumb-1.jpg') }}" alt=""></li>
                            <li data-tab="#tab-2" class="tab-btn"><img src="{{ asset('assets/client/dist/images/resource/project-thumb-2.jpg') }}" alt=""></li>
                            <li data-tab="#tab-3" class="tab-btn"><img src="{{ asset('assets/client/dist/images/resource/project-thumb-3.jpg') }}" alt=""></li>
                        </ul>

                        <!--Tabs Container-->
                        <div class="tabs-content">
                            <!--Tab / Active Tab-->
                            <div class="tab active-tab" id="tab-1">
                                <figure class="image"><a href="{{ asset('assets/client/dist/images/resource/project-single-1.jpg') }}" class="lightbox-image" data-fancybox="images"><img src="{{ asset('assets/client/dist/images/resource/project-single-1.jpg') }}" alt=""></a></figure>
                            </div>

                            <!--Tab-->
                            <div class="tab" id="tab-2">
                                <figure class="image"><a href="{{ asset('assets/client/dist/images/resource/project-single-2.jpg') }}" class="lightbox-image" data-fancybox="images"><img src="{{ asset('assets/client/dist/images/resource/project-single-2.jpg') }}" alt=""></a></figure>
                            </div>

                            <!--Tab-->
                            <div class="tab" id="tab-3">
                                <figure class="image"><a href="{{ asset('assets/client/dist/images/resource/project-single-3.jpg') }}" class="lightbox-image" data-fancybox="images"><img src="{{ asset('assets/client/dist/images/resource/project-single-3.jpg') }}" alt=""></a></figure>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Lower Content-->
                <div class="lower-content">
                    <div class="row clearfix">
                        <!--Content Column-->
                        <div class="content-column col-lg-8 col-md-12 col-sm-12">
                            <div class="inner-column">
                                <h2>Project Descripation</h2>
                                <p>Well we’re movin’ on up to the east side. To a deluxe apartment in the sky. The weather started getting rough – the tiny ship was tossed. If not for the courage of the fearless crew the Minnow would be lost. the Minnow would be lost. We’re gonna do it. On your mark get set and go now. Got a dream and we just know now we’re gonna make our dream come true. I have always wanted to have a neighbor just like you. I’ve always wanted to live in a neighborhood with you.</p>
                                <h4>Project Challenge</h4>
                                <p>It’s time to put on makeup. It’s time to dress up right. It’s time to raise the curtain on the Muppet Show tonight. The mate was a mighty sailin’ man the Skipper brave and sure.</p>
                                <ul class="list-style-one">
                                    <li>Five passengers set sail that day for a three hour</li>
                                    <li>Till the one day when the lady met this fellow</li>
                                    <li>Family that’s the way we all became the brady</li>
                                    <li>Champion the cause of the innocent career</li>
                                    <li>Now were up in the big leagues getting’ turn</li>
                                    <li>The powerless in a world of criminals operate</li>
                                </ul>
                                <h4>What We Did</h4>
                                <p>Then along come two they got nothin’ but their jeans. Texas tea. Knight Rider: A shadowy flight into the dangerous world of a man who does not exist. The first mate and his Skipper too will do their very best to make the tropic island nest.</p>
                                <h4>RESULT</h4>
                                <p>That’s just a little bit more than the law will allow. We’re gonna do it. On your mark get set and go now. Got a dream and we just know now we’re gonna make our dream come true. Makin their way the only way they know how. That’s just a little bit more than the law will allow.</p>
                            </div>
                        </div>

                        <!--Info Column-->
                        <div class="info-column col-lg-4 col-md-12 col-sm-12 ">
                            <div class="inner-column wow fadeInRight">
                                <h3>Project Information</h3>
                                <p>These men promptly escaped from a maximum security stockade to the Los Angeles underground. Love exciting and new. Come aboard were expecting you. Love life's sweetest reward Let it flow it floats back to you. Well the first thing you know ol' Jeds a mil lionaire infolk said Jed move away.</p>
                                <ul class="info-list">
                                    <li><strong>Client :</strong> Mandola Mogana</li>
                                    <li><strong>Location :</strong> London Donec eleifend 96502</li>
                                    <li><strong>Surface Area :</strong> 500,000 m2</li>
                                    <li><strong>Year Completed :</strong> 2017</li>
                                    <li><strong>Value :</strong> $550.000</li>
                                    <li><strong>Architect :</strong> Harri & Gary</li>
                                </ul>

                                <!--Help Box-->
                                <div class="help-box-two">
                                    <div class="inner">
                                        <span class="title">Quick Contact</span>
                                        <h2>Get Solution</h2>
                                        <div class="text">Contact us at the Interior office nearest to you or submit a business inquiry online.</div>
                                        <a class="theme-btn btn-style-two" href="#">Contact</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Portfolio Details-->

@endsection