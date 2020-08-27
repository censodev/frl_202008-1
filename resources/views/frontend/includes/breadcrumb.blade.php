@if( !empty($data['category']->images) )
    <style>
        .background-category > div{
            background: url("{{ $data['category']->images }}");
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
@endif
<div id="slideshow-menu">
    <div class="container">
        <div class="row wp-slideshow-menu">
            <div class="col-lg-3 wp-menu">
                @include('frontend.pages.home.partial.sidebar-menu')
            </div>
            <div class="col-md-9 background-category">
                <div> </div>
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
                    <li class="active">{{ $data['category']->title }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

