{{-- resources/views/custom-pagination.blade.php
@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link 
        @if ($paginator->onFirstPage())
            <span class="disabled"><i class="fas fa-chevron-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements 
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator 
            @if (is_string($element))
                <span class="disabled">{{ $element }}</span>
            @endif

            {{-- Array Of Links 
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link 
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fas fa-chevron-right"></i></a>
        @else
            <span class="disabled"><i class="fas fa-chevron-right"></i></span>
        @endif
    </div>
    
    <div style="text-align: center; margin-top: 15px; color: #7f8c8d; font-size: 14px;">
        Menampilkan {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} dari {{ $paginator->total() }} responden
    </div>
@endif --}}