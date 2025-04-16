@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-end">

            {{-- Previous Page Link --}}
            <li @class([
    'page-item',
     'disabled' => $paginator->onFirstPage()
     ])>
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                    <span aria-hidden="true">&laquo;</span>
                    {{ __('pagination.previous') }}
                </a>
            </li>

            {{-- Next Page Link --}}
            <li @class([
    'page-item',
     'disabled' => $paginator->hasMorePages()
     ])>
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                    {{ __('pagination.next') }}
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>

        </ul>
    </nav>
@endif
