<button class="btn btn-outline-primary btn-sm {{ $is_favorited ? 'active' : '' }} favorite-button"
  hx-post="/htmx/articles/{{ $article->slug }}/favorite"

  @if (isset($oob_swap))
  hx-swap-oob="outerHTML:.favorite-button"
  @endif
>
  <i class="ion-heart"></i>
  @if ($is_favorited)
  Unfavorite Post    
  @else
  Favorite Post
  @endif
  ({{ $favorite_count }})
</button>