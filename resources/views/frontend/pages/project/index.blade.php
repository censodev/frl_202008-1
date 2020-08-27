@extends($data->layout)

@section('title')
    {{ $data->title }}
@endsection

@section($data->content)

	<!-- Projects Section -->
    <section class="projects-section alternate">
        <div class="auto-container">
             <!--MixitUp Galery-->
            <div class="mixitup-gallery">
                <!--Filter-->
                <div class="filters text-center clearfix">
                    <ul class="filter-tabs filter-btns clearfix">
                        <li class="active filter" data-role="button" data-filter="all">All</li>
                        <li class="filter" data-role="button" data-filter=".commercial">COMMERCIAL</li>
                        <li class="filter" data-role="button" data-filter=".landescape">LANDESCAPE</li>
                        <li class="filter" data-role="button" data-filter=".interior">INTERIOR</li>
                        <li class="filter" data-role="button" data-filter=".architecture">ARCHITECTURE</li>
                    </ul>
                </div>

                <div class="filter-list row">
                    <!-- Project Block -->
                    <div class="project-block all mix interior architecture landescape col-lg-4 col-md-6 col-sm-12">
                        <div class="image-box">
                            <figure class="image"><img src="{{ asset('assets/client/dist/images/gallery/2-1.jpg') }}" alt=""></figure>
                            <div class="overlay-box">
                                <h4><a href="#">Laxury Home <br>Project</a></h4>
                                <div class="btn-box">
                                    <a href="{{ asset('assets/client/dist/images/gallery/2-1.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
                                    <a href="#"><i class="fa fa-external-link"></i></a>
                                </div>
                                <span class="tag">Architecture</span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Block -->
                    <div class="project-block all mix landescape architecture col-lg-8 col-md-6 col-sm-12">
                        <div class="image-box">
                            <figure class="image"><img src="{{ asset('assets/client/dist/images/gallery/2-2.jpg') }}" alt=""></figure>
                            <div class="overlay-box">
                                <h4><a href="#">Laxury Home <br>Project</a></h4>
                                <div class="btn-box">
                                    <a href="{{ asset('assets/client/dist/images/gallery/2-2.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
                                    <a href="#"><i class="fa fa-external-link"></i></a>
                                </div>
                                <span class="tag">Architecture</span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Block -->
                    <div class="project-block all mix landescape interior col-lg-6 col-md-6 col-sm-12">
                        <div class="image-box">
                            <figure class="image"><img src="{{ asset('assets/client/dist/images/gallery/2-3.jpg') }}" alt=""></figure>
                            <div class="overlay-box">
                                <h4><a href="#">Laxury Home <br>Project</a></h4>
                                <div class="btn-box">
                                    <a href="{{ asset('assets/client/dist/images/gallery/2-3.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
                                    <a href="#"><i class="fa fa-external-link"></i></a>
                                </div>
                                <span class="tag">Architecture</span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Block -->
                    <div class="project-block all mix landescape commercial architecture col-lg-6 col-md-6 col-sm-12">
                        <div class="image-box">
                            <figure class="image"><img src="{{ asset('assets/client/dist/images/gallery/2-4.jpg') }}" alt=""></figure>
                            <div class="overlay-box">
                                <h4><a href="#">Laxury Home <br>Project</a></h4>
                                <div class="btn-box">
                                    <a href="{{ asset('assets/client/dist/images/gallery/2-4.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
                                    <a href="#"><i class="fa fa-external-link"></i></a>
                                </div>
                                <span class="tag">Architecture</span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Block -->
                    <div class="project-block all mix landescape interior col-lg-4 col-md-6 col-sm-12">
                        <div class="image-box">
                            <figure class="image"><img src="{{ asset('assets/client/dist/images/gallery/2-5.jpg') }}" alt=""></figure>
                            <div class="overlay-box">
                                <h4><a href="#">Laxury Home <br>Project</a></h4>
                                <div class="btn-box">
                                    <a href="{{ asset('assets/client/dist/images/gallery/2-5.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
                                    <a href="#"><i class="fa fa-external-link"></i></a>
                                </div>
                                <span class="tag">Architecture</span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Block -->
                    <div class="project-block all mix landescape commercial interior col-lg-4 col-md-6 col-sm-12">
                        <div class="image-box">
                            <figure class="image"><img src="{{ asset('assets/client/dist/images/gallery/2-6.jpg') }}" alt=""></figure>
                            <div class="overlay-box">
                                <h4><a href="#">Laxury Home <br>Project</a></h4>
                                <div class="btn-box">
                                    <a href="{{ asset('assets/client/dist/images/gallery/2-6.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
                                    <a href="#"><i class="fa fa-external-link"></i></a>
                                </div>
                                <span class="tag">Architecture</span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Block -->
                    <div class="project-block all mix landescape interior col-lg-4 col-md-6 col-sm-12">
                        <div class="image-box">
                            <figure class="image"><img src="{{ asset('assets/client/dist/images/gallery/2-7.jpg') }}" alt=""></figure>
                            <div class="overlay-box">
                                <h4><a href="#">Laxury Home <br>Project</a></h4>
                                <div class="btn-box">
                                    <a href="{{ asset('assets/client/dist/images/gallery/2-7.jpg') }}" class="lightbox-image" data-fancybox="gallery"><i class="fa fa-search"></i></a>
                                    <a href="#"><i class="fa fa-external-link"></i></a>
                                </div>
                                <span class="tag">Architecture</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--Post Share Options-->
            <div class="styled-pagination">
                <ul class="clearfix">
                    <li class="prev-post"><a href="#"><span class="fa fa-long-arrow-left"></span> Trước</a></li>
                    <li><a href="#">1</a></li>
                    <li class="active"><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li class="next-post"><a href="#"> Tiếp Theo <span class="fa fa-long-arrow-right"></span> </a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End Projects Section -->

@endsection