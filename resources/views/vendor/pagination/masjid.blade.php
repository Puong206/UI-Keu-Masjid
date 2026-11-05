@if ($paginator->hasPages())
    <nav class="lap-pages" role="navigation" aria-label="Paginasi">
        @if ($paginator->onFirstPage())
            <span class="is-disabled" aria-disabled="true"><svg class="ic"><use href="#i-chevron-left"/></svg></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya"><svg class="ic"><use href="#i-chevron-left"/></svg></a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="is-gap">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="is-active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" aria-label="Ke halaman {{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya"><svg class="ic"><use href="#i-chevron"/></svg></a>
        @else
            <span class="is-disabled" aria-disabled="true"><svg class="ic"><use href="#i-chevron"/></svg></span>
        @endif
    </nav>
@endif
