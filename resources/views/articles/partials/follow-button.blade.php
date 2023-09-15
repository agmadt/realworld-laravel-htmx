<button class="btn btn-sm btn-outline-secondary follow-button"
  hx-post="/htmx/articles/follow-user/{{ $user->username }}"

  @if (isset($oob_swap))
  hx-swap-oob="outerHTML:.follow-button"
  @endif
>
  @if ($is_followed)
    <i class="ion-minus-round"></i>
    Unfollow 
  @else
    <i class="ion-plus-round"></i>
    Follow 
  @endif
  {{ $user->name }} 
  <span class="counter">({{ $follower_count }})</span>
</button>