<ul class="menu-landing">
    <li>
        <a href="/" title="Trang chủ" alt="Thủ tục sang tên sổ đỏ">
            <i class="fa fa-home" aria-hidden="true" style="font-size: 24px;"></i>
        </a>
    </li>

    @if(!empty($data['category_landing']) && count($data['category_landing']))
        @foreach($data['category_landing'] as $key => $item)
            <li>
                <a class="item" href="{{'#'.$item->section_scroll}}" title="{{ $item->title }}">
                    {{ $item->title }}
                </a>
            </li>
        @endforeach
    @endif
</ul>
