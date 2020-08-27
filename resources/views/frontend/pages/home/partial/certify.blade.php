@if( !empty( $home_default->title_certify ) || !empty( $home_default->description_certify ) || !empty( $related_certifies ))
    <div class="ereaders-main-section ereaders-certify-sliderfull">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ereaders-fancy-title">
                        <h2 class="bounceIn wow">{{ $home_default->title_certify }}</h2>
                        <div class="clearfix"></div>
                        <div class="fadeInRight wow">
                            {!! $home_default->description_certify !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12 fadeInUp wow">
                    @if( !empty( $related_certifies ) && count( $related_certifies ) > 0 && !empty( $related_certifies[0] ) )
                            @php
                                $certifies = [];
                                $certify_images = [];
                                $certify_title_image = [];
                                $certify_alt_image = [];

                                foreach ($related_certifies as $key => $item_certifies){
                                    $certifies[]                = $item_certifies;
                                    $certify_images[]           = !empty( $item_certifies->images ) ? json_decode( $item_certifies->images )[0] : '';
                                    $certify_title_image[]      = !empty( $item_certifies->title_image ) ? json_decode( $item_certifies->title_image )[0] : '';
                                    $certify_alt_image[]        = !empty( $item_certifies->alt_image ) ? json_decode( $item_certifies->alt_image )[0] : '';

                                }
                            @endphp

                            <div class="owl-carousel">
                                @foreach( $certifies as $key => $certify )
                                    @php
                                        $index = count($certify_images);
                                    @endphp
                                    <!-- certify Block -->
                                        <div class="image-box" onclick="openModal();" certify_id="{{$certify->id}}">
                                            <div style="background-image: url('{{ $certify_images[$key] }}');
                                                width: 100%;
                                                height: 250px;
                                                background-size:cover;
                                                background-position: center;
                                                background-repeat: no-repeat;
                                                "
                                            ></div>
                                        </div>
                                @endforeach
                            </div>

                                <div class="modal" id="myModal">
                                    <div class="modal-content">
                                        <span class="close-box cursor" onclick="closeModal()">&times;</span>
                                        <div class="list-images">
                                        </div>
                                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                                    </div>
                                </div>
                            @endif
                </div>
            </div>
        </div>
    </div>
@endif

<style>
    .row > .column {
        padding: 0 8px;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Create four equal columns that floats next to eachother */
    .column {
        float: left;
        width: 25%;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        position: fixed;
        z-index: 99999;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        overflow: auto;
        margin: 0px auto !important;
        background-color: #00000040;
    }

    /* Modal Content */
    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: auto;
        padding: 0;
        width: 70%;
    }
    .close-box{
        right: 3px;
        position: absolute;
        font-size: 24px;
        top: 0px;
        line-height: 22px;
        cursor: pointer;
        color: #FF0000;
        font-weight: bold;
    }

    /* The Close Button */
    .close {
        color: white;
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 35px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #999;
        text-decoration: none;
        cursor: pointer;
    }

    /* Hide the slides by default */
    .mySlides {
        display: none;
        padding: 30px;
    }

    /* Next & previous buttons */
    .prev,
    .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 5px;
        color: #000 !important;
        font-weight: bold;
        font-size: 20px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
        -webkit-user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover,
    .next:hover {
        background-color: #59c270;
    }

    /* Number text (1/3 etc) */
    .numbertext {
        color: #000;
        font-size: 12px;
        padding: 5px 0px;
        position: absolute;
        top: 0;
        line-height: 12px;
    }

    /* Caption text */
    .caption-container {
        text-align: center;
        background-color: black;
        padding: 2px 16px;
        color: white;
    }

    img.demo {
        opacity: 0.6;
    }

    .active,
    .demo:hover {
        opacity: 1;
    }

    img.hover-shadow {
        transition: 0.3s;
    }

    .hover-shadow:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
</style>

<script>
    // Open the Modal
    function openModal() {
        document.getElementById("myModal").style.display = "block";
    }

    // Close the Modal
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }

    var slideIndex = 1;
    showSlides(slideIndex);

    // Next/previous controls
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    // Thumbnail image controls
    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
        captionText.innerHTML = dots[slideIndex-1].alt;
    }
</script>
