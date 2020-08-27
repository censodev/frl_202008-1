<ul>
    <li>
        <a href="{{ Request::root() }}" title="Trang chủ">
            <i class="fa fa-home" aria-hidden="true" style="font-size: 24px;"></i>
        </a>
    </li>

    @foreach ($categories as $category)
        @if ($category->parent_id== -1)
            @if( @$category['childrens'] )
                <li>
                    <a href="{{ asset( change_cat_url_by_article_url( $category ) ) }}" title="{{ $category['title'] }}">{{ $category['title'] }} <i class="ion-chevron-down"></i> </a>
                    {!! gen_html_dropdown_submenu($category['childrens']) !!}
                </li>
            @else
                <li>
                    <a href="{{ asset( change_cat_url_by_article_url( $category ) ) }}" title="{{ $category['title'] }}">{{ $category['title'] }}</a>
                </li>
            @endif
        @endif
    @endforeach

</ul>
