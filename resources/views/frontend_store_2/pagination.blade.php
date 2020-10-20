@if ($paginate->lastPage() > 1)
    <ul class="pagination">
        <li class="page-item {{ ($paginate->currentPage() == 1) ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginate->url(1) }}">Previous</a>
        </li>
        @for ($i = 1; $i <= $paginate->lastPage(); $i++)
            <li class="page-item {{ ($paginate->currentPage() == $i) ? 'active' : '' }}">
                <a class="page-link" href="{{ $paginate->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        <li class="page-item {{ ($paginate->currentPage() == $paginate->lastPage()) ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginate->url($paginate->currentPage()+1) }}" >Next</a>
        </li>
    </ul>
@endif