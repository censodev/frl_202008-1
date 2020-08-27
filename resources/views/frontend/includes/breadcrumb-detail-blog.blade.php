@if( !empty($data['category_detail']->images_detail) )
    <style>
        .background-category > div{
            background: url("{{ $data['category_detail']->images_detail }}");
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
@endif

<div id="slideshow-menu">
    <div class="container wp-breadcrumb">
        <div class="row">
            <div class="col-lg-3 wp-menu">
                @include('frontend.pages.home.partial.sidebar-menu')
            </div>
            <div class="col-md-9 background-category">
                <div></div>
                {{--                    <h1> {{ $data['category']->title }} </h1>--}}
            </div>
        </div>
    </div>
</div>

<div class="ereaders-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul>
                    <li><a href="/" title="trang chủ">Trang chủ</a></li>
                    <li><a href="{{ url($data['category_detail']->alias) }}" title="{{ $data['category_detail']->title }}">{{ $data['category_detail']->title }}</a></li>
                    <li class="active">{{ $post_detail->title }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>




