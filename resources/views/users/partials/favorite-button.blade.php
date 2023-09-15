<button class="btn btn-outline-primary btn-sm pull-xs-right {{ $is_favorited ? 'active' : '' }}"
  hx-post="/htmx/users/articles/{{ $article->slug }}/favorite"
  
  @if (isset($is_current_user) && $is_current_user)
  hx-swap="delete"
  hx-target="closest .post-preview"
  @else
  hx-swap="outerHTML"
  @endif
>
  <i class="ion-heart"></i> {{ $favorite_count }}
</button>