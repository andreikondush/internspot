<nav class="pagination-box">
    <ul class="pagination">

        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">
                    <span>Previous</span>
                </a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1">
                    <span>Previous</span>
                </a>
            </li>
        @endif

        <!-- Pagination Elements -->
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item active">
                    {{ $element }}
                </li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="page-link">{{ $page }}</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                    <span>Next</span>
                </a>
            </li>
        @else
            <li class="page-item disabled">
                <a class="page-link">
                    <span>Next</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
