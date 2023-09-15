<button class="btn btn-sm btn-outline-secondary follow-button action-btn"
  hx-post="/htmx/users/{{ $user->username }}/follow"
  hx-swap="outerHTML"
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