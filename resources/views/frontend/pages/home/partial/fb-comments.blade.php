<div class="d-flex flex-column fb-container ereaders-main-section" style="padding-top: 20px!important">
    <div class="container">
        @if (!is_null($data['fb_comments']) && count($data['fb_comments']) > 0)
            <style>
                .fb-avt {
                    width: 5rem;
                    height: 5rem;
                    object-fit: cover;
                }

                .fb-title {
                    font-weight: 600;
                    white-space: nowrap;
                    font-size: 15px;
                    color: #385898 !important;
                }

                .d-flex {
                    display: flex;
                }

                .flex-column {
                    flex-direction: column;
                }

                .align-items-start {
                    align-items: flex-start;
                }

                .ml-3 {
                    margin-left: 1rem;
                }

            </style>
            <div><b style="color:#1c1e21">{{ count($data['fb_comments']) }} bình luận</b></div>
            <hr style="margin-top:15px">
            @foreach ($data['fb_comments'] as $cmt)
                <div class="d-flex align-items-start">
                    <img class="fb-avt" src="{{ $cmt->image }}" alt="{{ $cmt->alt_image }}">
                    <div class="d-flex flex-column ml-3">
                        <a class="fb-title" href="#">{{ $cmt->name }}</a>
                        <div style="font-size:15px">{{ $cmt->content }}</div>
                        <div style="font-size:12px">
                            <a style="color:#4267b2" href="#">Thích</a> ·
                            <a style="color:#4267b2" href="#">Phản hồi</a> ·
                            <a style="color:#90949c">{{ $cmt->time }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div width="100%" class="fb-comments" data-href="http://suakhoa.vemaybayremoingay.vn" data-numposts="5"
                data-width=""></div>

            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous"
                src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v8.0&appId=768055400268858&autoLogAppEvents=1"
                nonce="GaUKWzz6"></script>
        @endif
    </div>
</div>
