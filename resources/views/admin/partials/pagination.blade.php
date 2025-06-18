@if ($paginator->hasPages())
    <nav aria-label="Pagination">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <!-- Showing results info -->
            <div class="d-flex align-items-center text-muted">
                <small class="fw-medium">
                    <span class="text-primary fw-bold">{{ number_format($paginator->firstItem() ?? 0) }}</span> - 
                    <span class="text-primary fw-bold">{{ number_format($paginator->lastItem() ?? 0) }}</span> 
                    of <span class="text-primary fw-bold">{{ number_format($paginator->total()) }}</span>
                </small>
            </div>

            <!-- Pagination links -->
            <div class="d-flex align-items-center gap-3">
                <!-- Page info for mobile -->
                <small class="text-muted d-none d-sm-block">
                    Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
                </small>
                
                <div class="btn-group btn-group-sm pagination-controls" role="group" aria-label="Pagination">
                    {{-- First Page Link --}}
                    @if ($paginator->currentPage() > 3)
                        <a href="{{ $paginator->appends(request()->query())->url(1) }}" 
                           class="btn btn-outline-secondary pagination-btn" title="First Page">
                            <i class="fas fa-angle-double-left"></i>
                            <span class="d-none d-md-inline ms-1">First</span>
                        </a>
                    @endif

                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="btn btn-outline-secondary disabled">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1">Prev</span>
                        </span>
                    @else
                        <a href="{{ $paginator->appends(request()->query())->previousPageUrl() }}" 
                           class="btn btn-outline-secondary pagination-btn" rel="prev" title="Previous Page">
                            <i class="fas fa-chevron-left"></i>
                            <span class="d-none d-sm-inline ms-1">Prev</span>
                        </a>
                    @endif

                    {{-- Page Numbers (only show on larger screens) --}}
                    <div class="d-none d-md-flex">
                        @php
                            $start = max($paginator->currentPage() - 2, 1);
                            $end = min($start + 4, $paginator->lastPage());
                            $start = max($end - 4, 1);
                        @endphp
                        
                        @for ($i = $start; $i <= $end; $i++)
                            @if ($i == $paginator->currentPage())
                                <span class="btn btn-primary active">{{ $i }}</span>
                            @else
                                <a href="{{ $paginator->appends(request()->query())->url($i) }}" 
                                   class="btn btn-outline-secondary pagination-btn">{{ $i }}</a>
                            @endif
                        @endfor
                    </div>

                    {{-- Current page indicator for mobile --}}
                    <span class="btn btn-primary active d-md-none">
                        {{ $paginator->currentPage() }}/{{ $paginator->lastPage() }}
                    </span>

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->appends(request()->query())->nextPageUrl() }}" 
                           class="btn btn-outline-secondary pagination-btn" rel="next" title="Next Page">
                            <span class="d-none d-sm-inline me-1">Next</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="btn btn-outline-secondary disabled">
                            <span class="d-none d-sm-inline me-1">Next</span>
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif

                    {{-- Last Page Link --}}
                    @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                        <a href="{{ $paginator->appends(request()->query())->url($paginator->lastPage()) }}" 
                           class="btn btn-outline-secondary pagination-btn" title="Last Page">
                            <span class="d-none d-md-inline me-1">Last</span>
                            <i class="fas fa-angle-double-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading effect to pagination buttons
            const paginationBtns = document.querySelectorAll('.pagination-btn');
            paginationBtns.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    // Add loading state
                    const originalContent = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    btn.classList.add('disabled');
                    
                    // Remove loading state after navigation (fallback)
                    setTimeout(function() {
                        btn.innerHTML = originalContent;
                        btn.classList.remove('disabled');
                    }, 2000);
                });
            });
        });
    </script>
@endif
