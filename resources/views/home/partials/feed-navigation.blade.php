<ul id="feed-navigation" class="nav nav-pills outline-active" hx-swap-oob="true">
  @foreach ($feedNavbarItems as $item)
    <li class="nav-item">
      <a class="nav-link {{ $item['is_active'] ? 'active' : '' }}"
        @if (!$item['is_active'])
          href="{{ $item['hx_push_url'] }}"
          hx-get="{{ $item['hx_get_url'] }}"
          hx-trigger="click"
          hx-target="#feed-post-preview"
          hx-push-url="{{ $item['hx_push_url'] }}"
        @endif
      >
        {{ $item['title'] }}
      </a>
    </li>
  @endforeach
</ul>