<ul id="user-feed-navigation" class="nav nav-pills outline-active" hx-swap-oob="true">
  @foreach ($user_feed_navbar_items as $item)
    <li class="nav-item">
      <a class="nav-link {{ $item['is_active'] ? 'active' : '' }}"
        href="{{ $item['url'] }}"
        hx-push-url="{{ $item['url'] }}"
        hx-get="{{ $item['hx_get_url'] }}"
        hx-trigger="click"
        hx-target="#user-post-preview"
      >
        {{ $item['title'] }}  
      </a>
    </li>
  @endforeach
<ul>