@if ($paginator->hasPages())
    <div class="ereaders-pagination">
        <ul class="page-numbers">

            <li>
                <a class="previous page-numbers" href="{{ $paginator->previousPageUrl() }}">
                    <span><i class="icon ereaders-arrow-point-to-right"></i></span>
                </a>
            </li>

            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="page-numbers current" href="{{ $url }}">{{ $page }}</span></li>
                        @else
                            <li><a class="page-numbers" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <li>
                <a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}">
                    <span><i class="icon ereaders-arrow-point-to-right"></i></span>
                </a>
            </li>
        </ul>

    </div>
@endif
