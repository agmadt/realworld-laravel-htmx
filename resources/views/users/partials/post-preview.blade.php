<div id="user-post-preview" hx-swap-oob="true">
  @forelse ($articles as $article)
    <div class="post-preview">
      <div class="post-meta">
        <a href="/users/{{ $article->user->username }}"
          hx-push-url="/users/{{ $article->user->username }}"
          hx-get="/htmx/users/{{ $article->user->username }}"
          hx-target="#app-body"
        >
          <img src="{{ $article->user->image }}" />
        </a>
        <div class="info">
          <a href="/users/{{ $article->user->username }}"
            hx-push-url="/users/{{ $article->user->username }}"
            hx-get="/htmx/users/{{ $article->user->username }}"
            hx-target="#app-body"
            class="author"
          >
            {{ $article->user->name }}
          </a>
          <span class="date">{{ $article->created_at->format('F jS') }}</span>
        </div>
    
        @include('users.partials.favorite-button', [
          'favorite_count' => $article->favoritedUsers->count(),
          'is_favorited' => auth()->user() ? $article->favoritedByUser(auth()->user()) : false
        ])
    
      </div>
      <a href="/articles/{{ $article->slug }}"
        hx-push-url="/articles/{{ $article->slug }}"
        hx-get="/htmx/articles/{{ $article->slug }}"
        hx-target="#app-body"
        class="preview-link"
      >
        <h1>{{ $article->title }}</h1>
        <p>{{ $article->description }}</p>
        <span>Read more...</span>
      </a>
    </div>
  @empty
  <div class="post-preview">
    <div class="alert alert-warning" role="alert">
      No articles are here... yet.
    </div>
  </div>
  @endforelse
</div>