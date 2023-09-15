<div class="post-page">

  <div class="banner">
    <div class="container">

      <h1>{{ $article->title }}</h1>

      <div class="post-meta">
        <a href="profile.html"><img src="{{ $article->user->image }}" /></a>
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

        @if ($article->user->isSelf)

          @include('articles.partials.edit-button', ['article' => $article])

          @include('articles.partials.delete-button', ['article' => $article])

        @else
        
          @include('articles.partials.follow-button', [
            'user' => $article->user,
            'follower_count' => $article->user->followers->count(),
            'is_followed' => auth()->user() ? $article->user->followedBy(auth()->user()) : false
          ])
          
          @include('articles.partials.favorite-button', [
            'show_text' => true,
            'favorite_count' => $favorite_count,
            'is_favorited' => $is_favorited
          ])

        @endif
      </div>

    </div>
  </div>

  <div class="container page">

    <div class="row post-content">
      <div class="col-md-12">
        {{ $article->body }}
      </div>
    </div>

    <hr />

    <div class="post-actions">
      <div class="post-meta">
        <a href="profile.html"><img src="{{ $article->user->image }}" /></a>
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

        @if ($article->user->isSelf)

          @include('articles.partials.edit-button', ['article' => $article])

          @include('articles.partials.delete-button', ['article' => $article])
            
        @else

          @include('articles.partials.follow-button', [
            'user' => $article->user, 
            'follower_count' => $article->user->followers->count(),
            'is_followed' => auth()->user() ? $article->user->followedBy(auth()->user()) : false
          ])

          @include('articles.partials.favorite-button', [
            'show_text' => true,
            'favorite_count' => $favorite_count,
            'is_favorited' => $is_favorited
          ])

        @endif
      </div>
    </div>

    <div class="row">
      <div class="col-md-8 col-md-offset-2" hx-get="/htmx/articles/{{ $article->slug }}/comments" hx-trigger="load"></div>
    </div>

  </div>

</div>