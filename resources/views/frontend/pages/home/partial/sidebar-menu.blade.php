<div class="sidebar-menu">
    <ul>
        <li class="mega-menu-position">
            <div class="icon-menu">
                <i class="fa fa-list-alt" aria-hidden="true"></i>
            </div>
            Danh Mục Sản Phẩm
        </li>
        @foreach ($category_products as $category)
            @if ($category->parent_id== -1)
                @if( @$category['childrens'] )
                    @foreach (@$category['childrens']->sortBy('ordering') as $item)
                        @php
                            $url = asset( change_cat_url_by_article_url( $item ) );
                        @endphp
                        <li class="mega-menu-position">
                            <div class="icon-menu">
                                {!! $item->icons !!}
                            </div>
                            <a href="{{ $url }}" title="{{ $item->title }}">{{ $item->title }}
                                @if( @$item['childrens'] )
                                    <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                @endif
                            </a>
                            @if( @$item['childrens'] )
                                @foreach (@$item['childrens'] as $tmp)
                                    {!! gen_html_dropdown_submenu_slider($item['childrens']) !!}
                                @endforeach
                            @endif
                        </li>
                    @endforeach
                @endif
            @endif
        @endforeach
    </ul>
</div>
