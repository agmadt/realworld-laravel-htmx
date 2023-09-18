@if ($paginator->hasPages())
  <nav id="feed-pagination" hx-swap-oob="true">
    <ul class="pagination">
      @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <li class="page-item {{ $page_number == $i ? 'active' : '' }}">
          <a class="page-link"
            href="{{ str_replace('htmx/home/', '', $paginator->path()) }}?page={{ $i }}"
            hx-push-url="{{ str_replace('htmx/home/', '', $paginator->path()) }}?page={{ $i }}"
            hx-get="{{ $paginator->path() }}?page={{ $i }}"
          >{{ $i }}</a>
        </li>
      @endfor
    </ul>
  </nav>
@else
  <nav id="feed-pagination" hx-swap-oob="true"></nav>
@endif
